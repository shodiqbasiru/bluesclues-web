<div class="row mt-4">
    <div class="col">
        <h4>Upload Proof of Payment</h4>
        <hr>
        <form wire:submit.prevent="submit" enctype="multipart/form-data">
            <div class="form-group">
                <label for="proof">Proof of Payment</label>
                <input id="proof" type="file" class="form-control @error('proof') is-invalid @enderror"
                    wire:model="proof">

                @error('proof')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-success btn-block">Upload</button>
        </form>
    </div>
</div>
