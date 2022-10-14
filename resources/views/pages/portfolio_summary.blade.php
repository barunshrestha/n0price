<div class="card" style="width: 25rem;">
    <div class="card-body">
        <h5 class="card-title">Your Portfolio</h5>
        <h6 class="card-text" id="total_holding_valuation"></h6>
        <?php
        $day_gain = $total_holdings_valuation - $total_holdings_valuation_yesterday;
        $day_gain = round($day_gain, 2);
        $total_gain = $total_holdings_valuation - $total_investment;
        ?>
        <h6 class="card-text" style="color:<?php echo $day_gain > 0 ? 'green' : 'red'; ?>  ">Total Gain :
            @if ($total_gain >= 0)
                ${{ number_format($total_gain, 2) }}
            @else
                -${{ number_format(abs($total_gain), 2) }}
            @endif

        </h6>
        <h6 class="card-text" style="color:<?php echo $day_gain > 0 ? 'green' : 'red'; ?>  ">Day Gain :
            @if ($day_gain >= 0)
                ${{ number_format($day_gain, 2) }}
            @else
                -${{ number_format(abs($day_gain), 2) }}
            @endif
        </h6>
    </div>
</div>
