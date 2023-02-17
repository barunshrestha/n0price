<tr>
    <td id="market-cap-asc-desc">Market Cap<i class="fa fa-sort" onclick="sortTableasc(0)"></i>
    </td>
    <td id="coin-asc-desc">Coin<i class="fa fa-sort" onclick="sortTabletextasc(1)"></i></td>
    <td colspan="5"> <input type="hidden" value="{{ $api_rate_limit_flag ?? 0 }}" id="api_rate_limit_flag">
        <input type="hidden" value="{{ $total_worth ?? 0 }}" id="total_worth_backend">
        <input type="hidden" value="{{ $invalid_wallet_address ?? '' }}" id="invalid_wallet_address_list">
    </td>
    <td id="return-asc-desc">Return <i class="fa fa-sort" onclick="sortTableasc(7)"></i></td>
    <td id="24hr-asc-desc">24hr <i class="fa fa-sort" onclick="sortTableasc(8)"></i></td>
    <td id="7d-asc-desc">7d <i class="fa fa-sort" onclick="sortTableasc(9)"></i></td>
    <td id="ath-asc-desc">ATH <i class="fa fa-sort" onclick="sortTableasc(10)"></i></td>
</tr>
@if (isset($worth))
    @foreach ($worth as $key => $data)
        <tr>
            <?php
            $usd = $data['current_usd'];
            $usd_24h_change = $data['24hr'];
            $usd_market_cap = $data['usd_market_cap'];
            // $total_buy_unit = $data['buy_unit'] ? $data['buy_unit'] : 0;
            // $total_sell_unit = $data['sell_unit'] ? $data['sell_unit'] : 0;
            // $req_unit = $total_buy_unit - $total_sell_unit;
            $calculated_worth = (string) $data['worth'];
            ?>
            <td style="text-align: right;">${{ number_format($usd_market_cap / 1000000, 0) }} M</td>
            @if ($usd_market_cap < 25000000)
                <td style="background:#e9fac8;color:black;">
                    <div class="d-flex">
                        {{ $key }}
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
                        {{ $key }}

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
                        {{ $key }}

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
                        {{ $key }}

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
                        {{ $key }}

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
            <td style="text-align: center; color:<?php echo $data['return'] > 0 ? 'green' : 'red'; ?>">{{ number_format($data['return'], 1) }}%</td>
            <td style="text-align: center; color:<?php echo $data['24hr'] > 0 ? 'green' : 'red'; ?>">{{ number_format($data['24hr'], 1) }}%</td>
            <td style="text-align: center; color:<?php echo $data['7d'] > 0 ? 'green' : 'red'; ?>">{{ number_format($data['7d'], 1) }}%</td>
            <td style="text-align: center; color:<?php echo $data['ATH'] > 0 ? 'green' : 'red'; ?>">{{ number_format($data['ATH'], 1) }}%</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="11" class="text-center">
            <h6>
                No transactions found.
            </h6>
        </td>
    </tr>
@endif
