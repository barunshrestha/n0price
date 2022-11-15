<div class="modal fade" id="excelImport" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import data from excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card px-3 container card-custom" style="width: 100%">
                    <a href="{{ route('transaction.excel.sample.download') }}" class="" data-toggle="tooltip"
                        title="Excel Sample">
                        Download Sample Excel
                    </a>
                    <form class="form" id="kt_form" action="{{ route('transaction.excel.import.submit') }}"
                        method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" id="dashboard-portfolio-id" value="{{ $portfolio_details->id }}" name="portfolio_id">
                        <div class="card-body">
                            <div class="form-group row">
                                <input name="file_name" type="file" accept="excel/*"
                                    class="form-control form-control-solid" placeholder="Choose File" required
                                    autocomplete="off" />
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary font-weight-bold"
                                id="coin-save-transaction-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
