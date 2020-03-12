Safety signup & login with RedBeanPHP 5.4 <br>
<pre><code>
USE:
create db.php:

//https://redbeanphp.com/index.php?p=/download
require 'rb.php';

//MariaDB (MySQL)
R::setup( 'mysql:host=localhost;dbname=mydatabase',
        'user', 'password' );

//PostgreSQL
R::setup( 'pgsql:host=localhost;dbname=mydatabase',
        'user', 'password' );

session_start();

R::close();

</code></pre>