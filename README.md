# banking-app
Banking app application

# Installation

#### Backend 

**Step 1:** run command

`$ git clone https://github.com/vhs1092/banking-app.git`

**Step 2:** Move into the new folder  `banking-app` 

`$ cd banking-app`

**Step 3:** Go to api folder and install dependencies with composer. 

`$ cd api`

`$ composer install`

**Step 4:** Copy the example env file and make the required configuration changes in the .env file

`$ cp .env.example .env`

**Step 5:** Generate a new application key

`$ php artisan key:generate`

**Step 6:** Run the migrations and seeders

`$ php artisan migrate --seed`

**Step 7:** Start the local development server

`$ php artisan serve`

**Step 8:** You can now access the server at `http://127.0.0.1:8000` or with a different port depending in your machine

### FronteEnd

**Step 1:** Navigate to web folder

`$ cd ../web`

**Step 2:** Install dependencies

`$ npm install` or `$ yarn install`

**Step 3:**  Run our web project

`$ npm run dev` or `yarn run dev`

**Step 4:** Now we can access the web in this url 

`http://localhost:3000/` or it with a different port depending in your machine

### TESTING

`$ cd api`

`php artisan test`
