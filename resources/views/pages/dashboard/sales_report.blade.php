<div class="row">
    <div class="col-md-12">
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-1">
                <div class="card-title">
                    <h3 class="card-label">
                        Sales
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-icon btn-sm btn-hover-light-primary mr-1" data-toggle="collapse" href="#sales-report"
                        role="button" aria-expanded="true" aria-controls="custom_kt" title="Toggle Card">
                        <i class="ki ki-arrow-down icon-nm"></i>
                    </a>
                </div>
            </div>
            <div id="sales-report" class="collapse show">
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <strong>The following report displays no. of sales for a workshop for last 5 days.</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 5%;"> S. # </th>
                                    <th scope="col" style="width: 35%;"> Dealer </th>
                                    <?php foreach ($date_range as $key => $value) : ?>
                                    <th scope="col" style="width: 10%;">
                                        <?php
                                        if ($key == 0) {
                                            $date = $value == $today ? 'Today' : 'Yesterday';
                                        } else {
                                            $date = $value;
                                        }
                                        ?>
                                        <a href="{{ route('customers.registration_list', ['date' => $value]) }}"
                                            target="_blank">{{ $date }}</a>
                                    </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 1;
                                foreach ($sales_details as $key => $val) {
                                    echo '<tr>';
                                    echo '<td>' . $cnt++ . '</td>';
                                    echo '<td>';
                                    if (isset($val['id'])) {
                                        echo '<a href="' . route('dealers.show', $val['id']) . '" target="_blank">' . $key . '</a>';
                                    } else {
                                        echo '<strong>' . $key . '</strong>';
                                    }

                                    echo '</td>';
                                    foreach ($date_range as $key => $value) {
                                        echo '<td>';
                                        if (isset($val[$value])) {
                                            if (isset($val['id'])) {
                                                echo '<a href="' . route('customers.sales_details', ['dealer_id' => $val['id'], 'date' => $value]) . '" target="_blank" style="color:green;font-weight:bold" title="New Sales">' . $val[$value] . '</a>';
                                            } else {
                                                echo '<strong>' . $val[$value] . '</strong>';
                                            }
                                        } else {
                                            echo '0';
                                        }
                                        echo '</td>';
                                    }
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
