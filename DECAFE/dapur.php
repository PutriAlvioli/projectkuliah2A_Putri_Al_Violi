<?php
include "proses/connect.php";

$query = mysqli_query($conn, "SELECT * FROM tb_list_order
    LEFT join tb_order ON tb_order.id_order = tb_list_order.kode_order
    LEFT join tb_daftar_menu ON tb_daftar_menu.id = tb_list_order.menu
    LEFT join tb_bayar ON tb_bayar.id_bayar = tb_order.id_order");


while ($record = mysqli_fetch_array($query)) {
  $result[] = $record;
}

$select_menu = mysqli_query($conn, "SELECT id,nama_menu FROM tb_daftar_menu");

?>
<!--Content-->
<div class="col-lg-9 mt-2">
  <div class="card">
    <div class="card-header">
      Halaman Dapur
    </div>
    <div class="card-body">
      <a href="order" class="btn btn-info mb-3">Back</a>
    </div>

    <!-- Modal Tambah Item Baru -->
    <div class="modal fade" id="tambahItem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-fullscreen-md-down">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Makanan dan Minuman</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="needs-validation" novalidate action="proses/proses_input_orderitem.php" method="POST">
              <input type="hidden" name="kode_order" value="<?php echo $kode ?>">
              <input type="hidden" name="meja" value="<?php echo $meja ?>">
              <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">
              <div class="row">
                <div class="col-lg-8">
                  <div class="form-floating mb-3">
                    <select class="form-select" name="" id="">
                      <option selected hidden value="">Pilih Menu</option>
                      <?php
                      foreach ($select_menu as $value) {
                        echo "<option value=$value[id]>$value[nama_menu]</option>";
                      }
                      ?>
                    </select>
                    <label for="menu">Menu Makanan/Minuman</label>
                    <div class="invalid-feedback">
                      Pilih Menu.
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Porsi" name="jumlah" required>
                    <label for="floatingInput">Jumlah Porsi</label>
                    <div class="invalid-feedback">
                      Masukkan Jumlah Porsi.
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="catatan" name="catatan">
                    <label for="floatingPassword">Catatan</label>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="input_orderitem_validate" value="12345">Save
                  changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Akhir Modal Tambah Item Baru -->

    <?php
    if (empty($result)) {
      echo "Data makanan dan minuman tidak ada";
    } else {
      foreach ($result as $row) {
    ?>

        <!-- Modal Edit-->
        <div class="modal fade" id="ModalEdit<?php echo $row['id_list_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-fullscreen-md-down">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Makanan dan Minuman</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="needs-validation" novalidate action="proses/proses_edit_orderitem.php" method="POST">
                  <input type="hidden" name="id" value="<?php echo $row['id_list_order'] ?>">
                  <input type="hidden" name="kode_order" value="<?php echo $kode ?>">
                  <input type="hidden" name="meja" value="<?php echo $meja ?>">
                  <input type="hidden" name="pelanggan" value="<?php echo $pelanggan ?>">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="form-floating mb-3">
                        <select class="form-select" name="" id="">
                          <option selected hidden value="">Pilih Menu</option>
                          <?php
                          foreach ($select_menu as $value) {
                            if ($row['menu'] == $value['id']) {
                              echo "<option selected value=[id]>$value[nama_menu]</option>";
                            } else {
                              echo "<option value=$value[id]>$value[nama_menu]</option>";
                            }
                          }
                          ?>
                        </select>
                        <label for="menu">Menu Makanan/Minuman</label>
                        <div class="invalid-feedback">
                          Pilih Menu.
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Porsi" name="jumlah" required value="<?php echo $row['jumlah'] ?>">
                        <label for="floatingInput">Jumlah Porsi</label>
                        <div class="invalid-feedback">
                          Masukkan Jumlah Porsi.
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="catatan" name="catatan" value="<?php echo $row['catatan'] ?>">
                        <label for="floatingPassword">Catatan</label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="edit_orderitem_validate" value="12345">Save
                      changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Akhir Modal Edit-->
      <?php
      }

      ?>

      <div class="table-responsif">
        <table class="table table-hover">
          <thead>
            <tr class="text-nowrap">
              <th scope="col">No</th>
              <th scope="col">Kode Order</th>
              <th scope="col">Waktu Order</th>
              <th scope="col">Menu</th>
              <th scope="col">Qty</th>
              <th scope="col">Catatan</th>
              <th scope="col">Status</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($result as $row) {
            ?>
              <tr>
                <td>
                  <?php echo $no++ ?>
                </td>
                <td>
                  <?php echo $row['kode_order'] ?>
                </td>
                <td>
                  <?php echo $row['waktu_order'] ?>
                </td>
                <td>
                  <?php echo $row['menu'] ?>
                </td>
                <td>
                  <?php echo $row['jumlah'] ?>
                </td>
                <td>
                  <?php echo $row['catatan'] ?>
                </td>
                <td>
                  <?php echo $row['status'] ?>
                </td>
                <td>
                  <div class="d-flex">
                    <button class="<?php echo (!empty($row['status'])) ? "btn btn-secondary btn-sm me-1 disabled" : "btn btn-primary btn-sm me-1"; ?>" data-bs-toggle="modal" data-bs-target="#ModalEdit
                                            <?php echo $row['id_list_order'] ?>">Terima
                    </button>
                    <button class="<?php echo (!empty($row['id_bayar'])) ? "btn btn-secondary btn-sm me-1 disabled" : "btn btn-danger btn-sm me-1"; ?>" data-bs-toggle="modal" data-bs-target="#ModalDelete
                                            <?php echo $row['id_list_order'] ?>">Siap Saji
                    </button>
                  </div>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    <?php
    }
    ?>
  </div>
</div>
</div>
<!--End Content-->