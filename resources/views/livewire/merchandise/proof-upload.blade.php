<div class="container-fluid" id="upload">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('merchandise.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Payment</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 header">
            <p>Lakukan pembayaran dari rekening bank BCA ke rekening berikut. dengan total <br>
                pembayaran Rp 150.000</p>
            <img src="{{ url('/assets/img/icons/bca.png') }}" alt="">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form wire:submit.prevent="submit" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <p>Bang Toyib</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Account Numbers</label>
                        <div class="d-flex justify-content-between">
                            <p id="accountNumber">33339546644</p>
                            <button type="button" onclick="copyText('accountNumber')">Copy</button>
                            <div class="notification" id="copyNotification"></div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="proof">Upload Receipt Of Payment</label>
                        <div class="d-flex">
                            @if ($preview)
                                <img src="{{ $preview }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
                            @endif
                            <input id="proof" type="file"
                                class="form-control @error('proof') is-invalid @enderror" wire:model="proof">
                        </div>

                        @error('proof')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-checkout">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function copyText() {
        const element = document.getElementById('accountNumber');
        const text = element.innerText;

        const tempInput = document.createElement('input');
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        const notification = document.getElementById('copyNotification');
        notification.innerText = 'Account number has been copied';
        notification.style.display = 'block';

        setTimeout(function() {
            notification.style.display = 'none';
        }, 1500);
    }
</script>
