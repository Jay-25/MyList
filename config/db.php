<?php
return [
            'class' => 'yii\db\Connection',
            // SQLite: sqlite:/path/to/dbfile
            // MySQL: mysql:host=localhost;dbname=testdb
            // PostgreSQL: pgsql:host=localhost;port=5432;dbname=testdb
            // SQL Server: mssql:host=localhost;dbname=testdb
            // SQL Server: sqlsrv:server=localhost;Database=testdb // for 2000,2005,2008
            // Oracle: oci:dbname=//localhost:1521/testdb
            'dsn' => 'pgsql:host=115.28.76.20;port=5432;dbname=mydb',
            'username' => 'postgres',
            'password' => 'postgres',
            'charset' => 'utf8'
];
