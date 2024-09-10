<!-- resources/views/partials/progress-bar.blade.php -->

<div class="progress-container mb-4">
    <ul class="progressbar">
        <li class="active">Pick Shop</li>
        <li class="active">Order Foods</li>
        <li class="active">Checkout</li>
    </ul>
</div>

<!-- Add the required CSS for the Progress Bar -->
<style>
    .progress-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .progressbar {
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding: 0;
        margin: 0;
        list-style: none;
        counter-reset: step;
    }

    .progressbar li {
        text-align: center;
        position: relative;
        flex-grow: 1;
        color: #7d7d7d;
        counter-increment: step;
    }

    .progressbar li::before {
        content: counter(step);
        width: 36px;
        height: 36px;
        line-height: 36px;
        display: block;
        font-size: 18px;
        color: #fff;
        background: #7d7d7d;
        border-radius: 50%;
        margin: 0 auto 10px auto;
    }

    .progressbar li::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 4px;
        background: #7d7d7d;
        top: 18px;
        left: -50%;
        z-index: -1;
    }

    .progressbar li:first-child::after {
        content: none;
    }

    .progressbar li.active {
        color: #0B1E59;
    }

    .progressbar li.active::before {
        background: #0B1E59;
    }

    .progressbar li.active::after {
        background: #0B1E59;
    }
</style>