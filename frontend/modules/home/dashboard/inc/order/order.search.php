<div class="container-lg d-flex justify-content-start m-0">
    <form action="" class="m-0 col-lg-6">
        <div class="input-group">
            <input type="search" class="form-control rounded-0" id="inputSearch" placeholder="Search"
                aria-label="Search">
            <button class="btn btn-primary" style="width: 5.75rem" type="submit"><span
                    data-feather="search"></span></button>
            <!-- This is a button for the collapse part -->
            <!-- <button class="btn btn-secondary rounded-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseSearchOption"
                aria-expanded="false" aria-controls="collapseSearchOption">
                <span data-feather="sliders"></span>
            </button> -->
        </div>
        <!-- This is a collapse part where the comment point -->
        <div class="card card-body rounded-0 d-flex flex-row justify-content-between mt-2">
            <div class="form-check form-check-inline me-2">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Order">
                <label class="form-check-label" for="inlineRadio1">By Order ID</label>
            </div>
            <div class="form-check form-check-inline me-2">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                    value="Customer">
                <label class="form-check-label" for="inlineRadio2">By Customer ID</label>
            </div>
            <div class="form-check form-check-inline me-2">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="User">
                <label class="form-check-label" for="inlineRadio3">By User ID</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4"
                    value="Something">
                <label class="form-check-label" for="inlineRadio4">By Something</label>
            </div>
        </div>
        <!-- End of collapse part -->
    </form>
</div>