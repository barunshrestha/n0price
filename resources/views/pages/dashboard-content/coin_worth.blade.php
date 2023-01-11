<tr>
    <td>Market Cap</td>
    <td>Coin</td>
    <td colspan="5"></td>
    <td>Return</td>
    <td>24hr</td>
    <td>7d</td>
    <td>ATH</td>
</tr>
@foreach ($portfolio as $key => $data)
    <tr>
        <?php
        $coin_id = $data->coin_id;
        $curr = "$data->coin_id";
        $usd = $worth[$curr]['current_usd'];
        $usd_24h_change = $worth[$curr]['24hr'];
        $usd_market_cap = $worth[$curr]['usd_market_cap'];
        $total_buy_unit = $data->buy_unit ? $data->buy_unit : 0;
        $total_sell_unit = $data->sell_unit ? $data->sell_unit : 0;
        $req_unit = $total_buy_unit - $total_sell_unit;
        $calculated_worth = $req_unit * $usd;
        ?>
        <td style="text-align: right;">${{ number_format($usd_market_cap/1000000,0) }} M</td>
        @if ($usd_market_cap < 25000000)
            <td style="background:#e9fac8;color:black;">
                <div class="d-flex">
                    {{ $data->coin_name }}
                    
                </div>
            </td>
            <td class="tabledata-veryhigh" style="text-align: right;">

                @if ($calculated_worth >= 0)
                    ${{ number_format($calculated_worth, 1) }}
                @else
                    -${{ number_format(abs($calculated_worth), 1) }}
                @endif

            </td>
            <td class="tabledata-high" style="text-align: right;">

            </td>
            <td class="tabledata-medium" style="text-align: right;">

            </td>
            <td class="tabledata-low" style="text-align: right;">

            </td>
            <td class="tabledata-verylow" style="text-align: right;">
            </td>
        @endif
        @if ($usd_market_cap > 25000000 && $usd_market_cap < 250000000)
            <td style="background:#fff3bf;color:black;">
                <div class="d-flex">
                    {{ $data->coin_name }}
                    
                </div>
            </td>
            <td class="tabledata-veryhigh">

            </td>
            <td class="tabledata-high" style="text-align: right;">
                @if ($calculated_worth >= 0)
                    ${{ number_format($calculated_worth, 1) }}
                @else
                    -${{ number_format(abs($calculated_worth), 1) }}
                @endif

            </td>
            <td class="tabledata-medium">

            </td>
            <td class="tabledata-low">

            </td>
            <td class="tabledata-verylow">

            </td>
        @endif
        @if ($usd_market_cap > 250000000 && $usd_market_cap < 1000000000)
            <td style="background:#d3f9d8;color:black;">
                <div class="d-flex">
                    {{ $data->coin_name }}
                    
                </div>
            </td>
            <td class="tabledata-veryhigh">

            </td>
            <td class="tabledata-high">

            </td>
            <td class="tabledata-medium" style="text-align: right;">
                @if ($calculated_worth >= 0)
                    ${{ number_format($calculated_worth, 1) }}
                @else
                    -${{ number_format(abs($calculated_worth), 1) }}
                @endif

            </td>
            <td class="tabledata-low">

            </td>
            <td class="tabledata-verylow">

            </td>
        @endif
        @if ($usd_market_cap > 1000000000 && $usd_market_cap < 25000000000)
            <td style="background:#ffd8a8;color:black;">
                <div class="d-flex">
                    {{ $data->coin_name }}
                    
                </div>
            </td>
            <td class="tabledata-veryhigh">

            </td>
            <td class="tabledata-high">

            </td>
            <td class="tabledata-medium">

            </td>
            <td class="tabledata-low" style="text-align: right;">
                @if ($calculated_worth >= 0)
                    ${{ number_format($calculated_worth, 1) }}
                @else
                    -${{ number_format(abs($calculated_worth), 1) }}
                @endif

            </td>
            <td class="tabledata-verylow">

            </td>
        @endif
        @if ($usd_market_cap > 25000000000)
            <td style="background:#ffa8a8;color:black;">
                <div class="d-flex">
                    {{ $data->coin_name }}
                    
                </div>
            </td>
            <td class="tabledata-veryhigh">

            </td>
            <td class="tabledata-high">

            </td>
            <td class="tabledata-medium">

            </td>
            <td class="tabledata-low">

            </td>
            <td class="tabledata-verylow" style="text-align: right;">
                @if ($calculated_worth >= 0)
                    ${{ number_format($calculated_worth, 1) }}
                @else
                    -${{ number_format(abs($calculated_worth), 1) }}
                @endif
            </td>
        @endif
        <td style="text-align: center; color:<?php echo $worth[$curr]['return'] > 0 ? 'green' : 'red'; ?>">{{ number_format($worth[$curr]['return'],1) }}%</td>
        <td style="text-align: center; color:<?php echo $worth[$curr]['24hr'] > 0 ? 'green' : 'red'; ?>">{{ number_format($worth[$curr]['24hr'],1) }}%</td>
        <td style="text-align: center; color:<?php echo $worth[$curr]['7d'] > 0 ? 'green' : 'red'; ?>">{{ number_format($worth[$curr]['7d'],1) }}%</td>
        <td style="text-align: center; color:<?php echo $worth[$curr]['ATH'] > 0 ? 'green' : 'red'; ?>">{{ number_format($worth[$curr]['ATH'],1) }}%</td>
    </tr>
@endforeach
