<div class="row justify-content-center" >
    <div class="col-6">
        <div class="card card-danger" style="border-radius: 15px 15px 15px 15px">
            <div class="card-header d-flex align-items-center justify-content-center" style="border-radius: 15px 15px 0 0">
                <h3 class="card-title text-center">TRANSCRIÇÃO DE VÍDEO DO YOUTUBE</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <div class="form-group">
                    <label for="link">Video:</label>
                    <input type="text" class="form-control" id="link" placeholder="Email" wire:model="input" disabled>
                </div>
            </div>
        </div>
        <div class="card card-danger" style="border-radius: 15px 15px 15px 15px">
            <div class="card-header d-flex align-items-center justify-content-center" style="border-radius: 15px 15px 0 0">
                <h3 class="card-title text-center">TRANSCRIÇÃO DO ÁUDIO</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <div class="border p-2 rounded">{{ $transcricao->texto ?: '' }}</div>
            </div>
        </div>
    </div>
</div>
