<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        // Get the submitted username and password from the request
        $credentials = $request->only('user', 'password');
        
        // Retrieve the user based on the entered credentials
        $user = $this->getUser($credentials['user'], $credentials['password']);
        
        // If the user exists, log them in and redirect to the dashboard
        if ($user) {
            Auth::loginUsingId($user['id']);
            return redirect('dashboard');
        }
        
        // If the user does not exist or the credentials are invalid,
        // redirect back to the login page with an error message
        return redirect('/login')->with('error', 'Invalid username or password.');
        
    }

    private function getUser($user, $password)
    {
        // Connection options for the SQL Server
        $connectionOptions = array(
            "Database" => "Sage Import",
            "Uid" => "sa",
            "PWD" => "HK-S@l2019"
        );

        // Connect to the SQL Server
        $conn = sqlsrv_connect("HK-SQL2019", $connectionOptions);

        // If the connection fails, print the error and stop execution
        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Query to retrieve the user from the database based on the username and password
        $query = "SELECT * FROM [Sage Import].[dbo].users WHERE [user] = '$user' AND [Password] COLLATE Latin1_General_CS_AS = '$password'";
        // $result = DB::connection('sage')->select($query);
        // dd($query);

        // Parameters to be bound to the query
        // $params = array($user, $password);
        // dd($query);

        // Execute the query with the provided parameters
        $result = sqlsrv_query($conn, $query);
        // dd($result, $query);
        
        // If the query execution fails, print the error and stop execution
        if ($result === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Fetch the user data from the result set
        $user = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
       
        // Close the database connection
        sqlsrv_close($conn);

        // Return the user data
        // dd($user);
        return $user;
    }

    public function logout()
    {
        // Log out the user
        Auth::logout();

        // Redirect to the login page
        return redirect('/login');
    }
}
