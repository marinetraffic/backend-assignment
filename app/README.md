<h1> Vessel Tracker </h1>

<h3> About </h3>
<p>
    I am using Laravel framework for the REST API to serve all the vessel tracking movements.
    As for the database MySQL is being used which is populated with data via Laravel seeder based
    on the MOCK JSON file located in database/data/ship_positions.json. 
</p>

<h3> Run Application </h3>
<p>
    To run the application you need to:
    <ul>
        <li> Download the repository. </li>
        <li> Using XAMPP you need to create a database by the name 'api'. </li>
        <li> Run Apache and MySQL modules from XAMPP panel. </li>
        <li> Go to /app folder and execute 'composer install' to install all dependencies based on the composer.json file. </li>
        <li> Run command `php artisan migrate` on folder /app to create the database table based on the <b>Migrations</b> of Laravel. </li>
        <li> 
            To populate the database table with the MOCK JSON file execute 
            `php artisan db:seed --class=PositionsTableSeeder` on the /app folder or 
            alternatively you can execute command `php artisan db:seed` to run 
            <b>ALL</b> seeders (both approaches will take some time). 
        </li>
        <li> Run command `php artisan serve` on folder /app to start the API.  </li>
        <li> 
            After that you can play around with the API either by using a tool such as 
            <a href='https://www.postman.com/'>Postman</a> or by using your web browser 
            (since all the endpoints are simple GET's). 
        </li>
        <li> You can change the 'Accept' header on Postman in order to change the media desired response. </li>
        <li> To run the tests go to /app folder and execute 'php artisan test'. </li>
    </ul>
</p>

<h3> General </h3>
<p>
    <ul>
        <li> About text/csv media type. The file is created on public/temp folder. </li>
    </ul>
</p>

<h3> Future Tweacks/Updates </h3>
<p>
    <ul>
        <li> 
            The request limit functionality that limits a user to call the API endpoints 
            to 10 calls/hour, it can be implemented with Redis to minimize the calls on the 
            database and for faster responses. 
        </li>
        <li> 
            Seperate bussiness login even further. Possibly adding a 'Service' layer to handle
            the queries so that the controller is seperate with the actual database communication
            and thus easier for unit testing.
        </li>
        <li> 
            Add pagination to route responses.
        </li>
    </ul>
</p>