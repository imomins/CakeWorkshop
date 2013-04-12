<?php foreach($booking['Booking'] as $booking): ?>
    <div class="nameplate">
        <p><?php echo $booking['User']['name']; ?></p>
    </div>
<?php endforeach; ?>

<style>
.nameplate {
    font-size: 60px;
    font-weight: bold;
    text-align: center;
    padding: 70px 50px;
    border: 3px solid black;
    margin-bottom: 10px;
}
</style>