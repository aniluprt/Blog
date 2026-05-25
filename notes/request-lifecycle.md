LARAVEL REQUEST LIFECYCLE



When a user submit a form to create a new blog post, below is  what happens from the browser to database and backend too.



1. Entry point public/index.php

all request enter through here and web server routes every request here. Laravel's autoloader loads all required classes from autoload.php 





2\. create app instance 

Laravel create instance of app and powers the whole framework. the instance is created at bootstrap/app.php





3\. HTTP kernel 

the request is sent to http kernel that defines array of bootstrapper.

load variables, 

load configuration,

handle exception,

register facades,

register service provider, 

boot service providers.





4\. service provider

they are registered and booted

database, validation, queue and routing are configured here 

all providers listed in config/app.php are loaded





5\. router 

request are handled here. routes matches the post request to /posts route to routes/web.php

Laravel checks if http method (POST) and URI matches the route





6\. middleware before controller 



Global Middleware (runs on every request):

&#x20;`App\\Http\\Middleware\\EncryptCookies`

&#x20;`Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse`

&#x20;`Illuminate\\Session\\Middleware\\StartSession`

&#x20;`Illuminate\\View\\Middleware\\ShareErrorsFromSession`

&#x20;`App\\Http\\Middleware\\VerifyCsrfToken` 





Route Middleware (specific to this route):

&#x20;`Illuminate\\Routing\\Middleware\\SubstituteBindings`

&#x20;`App\\Http\\Middleware\\Authenticate` (checks if user is logged in)

&#x20;`App\\Http\\Middleware\\EnsureUserIsActive` (custom - checks if account is active)

&#x20;`App\\Http\\Middleware\\LogRequestDetails` (custom - logs request details)





7\. controller 

request reaches postcontroller method 

Laravel automatically injects storepostrequest for validation 

it is an dependency injection 





8\. form validation

storepostrequest validates data before controller runs 

\- Validation rules:

&#x20; title`: required, min 5, max 255 characters

&#x20; body`: required, min 100 characters

&#x20; slug`: optional, must be unique, only lowercase letters/numbers/hyphens

&#x20; is\_published`: boolean

&#x20; category\_ids`: array of existing category IDs



\- If validation fails:

&#x20; User is redirected back to form

&#x20; Error messages are flashed to session

&#x20; Old input is flashed to session

\-If validation passes:

&#x20; Validated data is available via `$request->validated()





9\. Database operations 

eloquent ORM builds sql query 

database returns the newly created post ID and eloquent hydrates the post model with data 





10\. response generation 

controller redirects to post.show route and generates URL 

success message stored in flash session data 





11\. middleware pipeline after controller 

response travels back through middleware in reverse order

each middleware can modify the response (encryptcookies, startsession)





12\. response sent to browser 

HTTP kernel returns response object 

browser receives redirect response 

browser automatically makes GET request to new URL 

user sees post page with success message 











13\. complete flow 



Browser (User submits form)

&#x20;   ↓

public/index.php

&#x20;   ↓

Create Application Instance

&#x20;   ↓

HTTP Kernel

&#x20;   ↓

Service Providers Registered \& Booted

&#x20;   ↓

Router (matches /posts POST route)

&#x20;   ↓

Global Middleware (inbound)

&#x20;   ↓

Route Middleware (inbound)

&#x20;   ↓

Controller (PostController@store)

&#x20;   ↓

FormRequest Validation (StorePostRequest)

&#x20;   ↓

Business Logic (create post, attach categories)

&#x20;   ↓

Database (INSERT query)

&#x20;   ↓

Response (redirect to /posts/my-post)

&#x20;   ↓

Route Middleware (outbound - reverse order)

&#x20;   ↓

Global Middleware (outbound - reverse order)

&#x20;   ↓

Response sent to Browser

&#x20;   ↓

Browser loads the post page









