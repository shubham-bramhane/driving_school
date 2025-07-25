<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;


function runTimeChecked($myId, $matchId)
{
    if ($myId == $matchId)
        return 'checked';
}

function getSystemRoles($role = null)
{
    $data = 'App\Models\Role'::when($role, function ($data) use ($role) {
        if ($role) {
            $data->where('id', '=',  $role);
        }
    })->get();
    return $data;
}

function runTimeSelection($myId, $matchId)
{
    if ($myId == $matchId)
        return 'selected';
}


function SidebarModules()
{
    $data = 'App\Models\Module'::
    where('status', 1)
    ->where('is_show_in_menu',1)
    ->orderBy('sort_order', 'asc')
    ->get();

    return $data;
}

function conditionalStatus($status)
{
    if ($status == '1') {
        $status = 1;
    }
    if ($status == '2') {
        $status = 0;
    }
    return $status;
}



function getRole()
{
    $role_id = Auth::user()->role_id;
    $data = 'App\Models\Role'::where('id', $role_id)->first();
    $role = $data->role;
    return $role;
}


function getRoleById($id)
{
    $data = 'App\Models\Role'::where('id', $id)->first();
    // dd($data);
    return $data;
}


function getCurrency($amount)
{
    $data = "₹ " . number_format($amount, 2);
    return $data;
}


function formatIndianCurrency($number) {
        $number = (int) $number;
        $num = preg_replace('/\D/', '', $number);
        $len = strlen($num);
        if ($len > 3) {
            $last3 = substr($num, -3);
            $rest = substr($num, 0, $len - 3);
            $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
            return $rest . "," . $last3;
        } else {
            return $num;
        }
}


function getProducts()
{
    $data = 'App\Models\Product'::where('status', 1)->orderBy('id', 'asc')->get();
    return $data;
}
