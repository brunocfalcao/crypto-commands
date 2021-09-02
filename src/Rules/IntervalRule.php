<?php

namespace Nidavellir\CryptoCommands\Rules;

use Illuminate\Contracts\Validation\Rule;

class IntervalRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $intervals = collect(['1m', '3m', '5m', '15m', '30m', '1h', '2h', '4h', '6h', '8h', '12h', '1d', '3d', '1w', '1M']);

        return $intervals->containsStrict($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Field should be a valid candlestick interval (https://binance-docs.github.io/apidocs/spot/en/#kline-candlestick-streams)';
    }
}
