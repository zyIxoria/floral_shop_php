<?php

namespace App\Helpers;

class FormatHelper
{
    /*
    |--------------------------------------------------------------------------
    | Format Currency
    |--------------------------------------------------------------------------
    */

    public static function currency($amount): string
    {
        return number_format($amount, 0, ',', '.') . 'đ';
    }

    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    public static function date($date): string
    {
        return date('d/m/Y', strtotime($date));
    }

    /*
    |--------------------------------------------------------------------------
    | Format DateTime
    |--------------------------------------------------------------------------
    */

    public static function datetime($date): string
    {
        return date('d/m/Y H:i', strtotime($date));
    }

    /*
    |--------------------------------------------------------------------------
    | Product Status Badge
    |--------------------------------------------------------------------------
    */

    public static function productStatus($status): string
    {
        return match($status)
        {
            'active' =>
                '<span class="badge bg-success">Active</span>',

            'inactive' =>
                '<span class="badge bg-secondary">Inactive</span>',

            default =>
                '<span class="badge bg-dark">Unknown</span>',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Order Status Badge
    |--------------------------------------------------------------------------
    */

    public static function orderStatus($status): string
    {
        return match($status)
        {
            'pending' =>
                '<span class="badge bg-warning">Pending</span>',

            'confirmed' =>
                '<span class="badge bg-info">Confirmed</span>',

            'shipped' =>
                '<span class="badge bg-primary">Shipping</span>',

            'delivered' =>
                '<span class="badge bg-success">Delivered</span>',

            'cancelled' =>
                '<span class="badge bg-danger">Cancelled</span>',

            default =>
                '<span class="badge bg-dark">Unknown</span>',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Limit Text
    |--------------------------------------------------------------------------
    */

    public static function limitText($text, $limit = 50): string
    {
        return strlen($text) > $limit
            ? substr($text, 0, $limit) . '...'
            : $text;
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Order Number
    |--------------------------------------------------------------------------
    */

    public static function orderNumber($id): string
    {
        return 'ORD-' .
            date('Ymd') .
            '-' .
            str_pad($id, 6, '0', STR_PAD_LEFT);
    }
}