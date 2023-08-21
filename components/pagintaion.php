<!-- pagination -->
<div class="pagination">
    <?php for ($i=1; $i <= $jumlahHalaman; $i++):?>
    <!-- <div> -->
        <a href="list_video.php?p=<?=$i?>">
            <div class="
            <?php if($i == $halamanAktif){
                echo 'pagination-selected';
                }else{
                    echo '';
                }; ?>
            ">
                <?= $i?>
            </div>
        </a>
    <!-- </div> -->
    <?php endfor?>
</div>
<!-- /pagination -->