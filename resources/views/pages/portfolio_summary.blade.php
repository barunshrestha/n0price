<div class="card" style="width: 25rem;">
  <div class="card-body">
    <h5 class="card-title">Your Portfolio</h5>
    {{-- <h6 class="card-subtitle mb-2" id="total_holding_valuation">Total: ${{number_format($total_holdings_valuation,2)}}</h6> --}}
    <h6 class="card-subtitle mb-2" id="total_holding_valuation"></h6>
    <?php
        $day_gain = $total_holdings_valuation - $total_holdings_valuation_yesterday;
        $day_gain = round($day_gain,2);
        $total_gain = $total_holdings_valuation - $total_investment;
    ?>
    <p class="card-text" style="color:<?php echo $day_gain > 0 ? 'green': 'red';?>  ">Total Gain : ${{number_format($total_gain,2)}}</p>
    <p class="card-text" style="color:<?php echo $day_gain > 0 ? 'green': 'red';?>  ">Day Gain : ${{number_format($day_gain,2)}}</p>
    
  </div>
</div>