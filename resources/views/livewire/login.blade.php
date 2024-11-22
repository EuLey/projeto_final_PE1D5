<div class="row justify-content-center" >
    <div class="col-6">
        <div class="card card-danger" style="border-radius: 15px 15px 15px 15px">
            <div class="card-header d-flex align-items-center justify-content-center" style="border-radius: 15px 15px 0 0">
                <h3 class="card-title text-center">LOGIN</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form wire:submit="fazerLogin">
                <div class="card-body">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" wire:model="email">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" placeholder="Senha" wire:model="senha">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex justify-content-center" style="border-radius: 0 0 15px 15px">
                    <button type="submit" class="btn btn-danger">Fazer login</button>
                </div>
            </form>
        </div>
    </div>
</div>
