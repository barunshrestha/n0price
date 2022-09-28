  <div class="card card-custom">
      <div class="card-header flex-wrap border-0 pt-6 pb-0">
          <div class="card-title">
              <h3 class="card-label">Asset Matrix
                  <span class="d-block text-muted pt-2 font-size-sm">Available Asset matrix</span>
              </h3>
          </div>
      </div>
      <div class="card-body">
          <table class="table" style="width: 100%">
              <thead>
                  <tr>
                      <th scope="col">Market Cap</th>
                      @foreach ($asset_matrix_constraints as $constraints)
                          <th scope="col" style="background: {{ $constraints->color }};color:black;">
                              {{ $constraints->market_cap }}</th>
                      @endforeach
                      <th>Total</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>
                          Risk
                      </td>
                      @foreach ($asset_matrix_constraints as $constraints)
                          <td>
                              {{ $constraints->risk }}
                          </td>
                      @endforeach
                  </tr>
                  <tr>
                      <td>
                          Allocation %
                      </td>
                      <form action="{{ route('percentage.allocation') }}" method="POST">
                          @csrf
                          @foreach ($asset_matrix_constraints as $constraints)
                              <td>
                                  <div class="hideAfteredit allocation-percentage">
                                      {{ $constraints->percentage_allocation }}
                                  </div>
                                  <input type="text" class="form-control hideBeforeedit hidden" name="allocation_percentage[]" value="{{ $constraints->percentage_allocation }}">
                              </td>
                          @endforeach
                          <td>
                              <div class="d-flex">
                                  <button class="btn btn-icon btn-success btn-xs allocationEditBtn" type="button"
                                      data-toggle="tooltip" title="Edit">
                                      <i class="fa fa-pen"></i>
                                  </button>
                                  <button class="btn btn-icon btn-success btn-xs ml-2 allocationSaveBtn hidden" type="submit"
                                      data-toggle="tooltip" title="Submit">
                                      <i class="fa fa-save"></i>
                                  </button>
                              </div>
                          </td>
                      </form>
                  </tr>
                  <tr>

                      <td>
                          To Allocate $
                      </td>
                      <td id="toallocate-veryhigh"></td>
                      <td id="toallocate-high"></td>
                      <td id="toallocate-medium"></td>
                      <td id="toallocate-low"></td>
                      <td id="toallocate-verylow"></td>
                  </tr>
                  <tr>

                      <td>
                          Allocated
                        </td>
                        <td id="allocated-veryhigh"></td>
                        <td id="allocated-high"></td>
                        <td id="allocated-medium"></td>
                        <td id="allocated-low"></td>
                        <td id="allocated-verylow"></td>
                        <td id="allocated-total"></td>
                  </tr>
                  <tr>

                      <td>
                          Not Allocated
                      </td>
                      <td id="not_allocated-veryhigh"></td>
                      <td id="not_allocated-high"></td>
                      <td id="not_allocated-medium"></td>
                      <td id="not_allocated-low"></td>
                      <td id="not_allocated-verylow"></td>
                      <td id="not_allocated-total"></td>
                  </tr>
                  @foreach ($portfolio as $key => $data)
                      <tr>
                          <?php
                          $curr = "$data->coin_id";
                          $usd = $current_price->$curr->usd;
                          $usd_24h_change = $current_price->$curr->usd_24h_change;
                          $usd_market_cap = $current_price->$curr->usd_market_cap;
                          
                          $total_buy_unit = $data->buy_unit ? $data->buy_unit : 0;
                          $total_sell_unit = $data->sell_unit ? $data->sell_unit : 0;
                          $req_unit = $total_buy_unit - $total_sell_unit;
                          ?>
                          @if ($usd_market_cap < 25000000)
                              <td style="background:#ffe599;color:black;">
                                  {{ $data->coin_name }}
                              </td>
                              <td class="tabledata-veryhigh">
                                  {{ $req_unit * $usd }}
                              </td>
                              <td class="tabledata-high">

                              </td>
                              <td class="tabledata-medium">

                              </td>
                              <td class="tabledata-low">

                              </td>
                              <td class="tabledata-verylow">
                              </td>
                          @endif
                          @if ($usd_market_cap > 25000000 && $usd_market_cap < 250000000)
                              <td style="background:#ffff00;color:black;">
                                  {{ $data->coin_name }}
                              </td>
                              <td class="tabledata-veryhigh">

                              </td>
                              <td class="tabledata-high">
                                  {{ $req_unit * $usd }}

                              </td>
                              <td class="tabledata-medium">

                              </td>
                              <td class="tabledata-low">

                              </td>
                              <td class="tabledata-verylow">

                              </td>
                          @endif
                          @if ($usd_market_cap > 250000000 && $usd_market_cap < 1000000000)
                              <td style="background:#00ff00;color:black;">
                                  {{ $data->coin_name }}
                              </td>
                              <td class="tabledata-veryhigh">

                              </td>
                              <td class="tabledata-high">

                              </td>
                              <td class="tabledata-medium">
                                  {{ $req_unit * $usd }}

                              </td>
                              <td class="tabledata-low">

                              </td>
                              <td class="tabledata-verylow">

                              </td>
                          @endif
                          @if ($usd_market_cap > 1000000000 && $usd_market_cap < 25000000000)
                              <td style="background:#ff9900;color:black;">
                                  {{ $data->coin_name }}
                              </td>
                              <td class="tabledata-veryhigh">

                              </td>
                              <td class="tabledata-high">

                              </td>
                              <td class="tabledata-medium">

                              </td>
                              <td class="tabledata-low">
                                  {{ $req_unit * $usd }}

                              </td>
                              <td class="tabledata-verylow">

                              </td>
                          @endif
                          @if ($usd_market_cap > 25000000000)
                              <td style="background:#ff0000;color:black;">
                                  {{ $data->coin_name }}
                              </td>
                              <td class="tabledata-veryhigh">

                              </td>
                              <td class="tabledata-high">

                              </td>
                              <td class="tabledata-medium">

                              </td>
                              <td class="tabledata-low">

                              </td>
                              <td class="tabledata-verylow">
                                  {{ $req_unit * $usd }}
                              </td>
                          @endif
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  </div>
