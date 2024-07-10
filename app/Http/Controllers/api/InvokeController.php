<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InvokeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($secretKey)
    {
        $key = 'keyresetpassword';
        if ($secretKey !== $key) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
    
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
        // Get all table names
        $tables = DB::select('SHOW TABLES');
        $databaseName = DB::getDatabaseName();
        
        foreach ($tables as $table) {
            $tableName = $table->{"Tables_in_$databaseName"};
            Schema::drop($tableName);
        }
    
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
        return response()->json(['message' => 'All tables have been dropped.']);
    }
}
