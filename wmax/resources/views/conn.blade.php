<!DOCTYPE html>
<html>
<head>
    <title>Database Connection Details</title>
</head>
<body>
    <h1>Database Connection Details</h1>

    @php
        $tableNames = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        $connectionName = Config::get('database.default');
        $connectionConfig = Config::get("database.connections.$connectionName");
    @endphp

    <p>Database Connection Name: {{ $connectionName }}</p>
    <p>Host: {{ $connectionConfig['host'] }}</p>
    <p>Database: {{ $connectionConfig['database'] }}</p>
    <p>Username: {{ $connectionConfig['username'] }}</p>
    <p>Password: {{ $connectionConfig['password'] }}</p>

    <h2>Table Names:</h2>
    <ul>
        @foreach ($tableNames as $tableName)
            <li>{{ $tableName }}</li>
        @endforeach
    </ul>
</body>
</html>