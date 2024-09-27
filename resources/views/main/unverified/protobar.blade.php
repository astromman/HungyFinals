<!-- resources/views/partials/progress-bar.blade.php -->

<div class="progress-wrapper px-1">
    <div class="progress-container">
        <!-- Step Circles -->
        <div class="steps">
            <span class="circle active">
                1
            </span>
            <span class="circle 
            {{ isset($shopDetails) && $shopDetails->status == 'Processing' ? 'active' : '' }}">
                2
            </span>
            <span class="circle {{ isset($shopDetails) && $shopDetails->status == 'Verified' ? 'active' : '' }}">
                3
            </span>
            <div class="progress-bar">
                <span class="indicator" style="width: 
                    {{ isset($shopDetails) && $shopDetails->status == 'Unverified'  ? '0%' : '' }}
                    {{ isset($shopDetails) && $shopDetails->status == 'Processing' ? '50%' : '' }}
                    {{ isset($shopDetails) && $shopDetails->status == 'Verified' ? '100%' : '' ;}}"></span>
            </div>
        </div>

        <!-- Step Texts (Separate Div) -->
        <div class="step-text-container">
            <span class="step-text">Upload Files</span>
            <span class="step-text">Processing</span>
            <span class="step-text">Complete</span>
        </div>
    </div>
</div>

<!-- CSS -->
<style>
    .progress-wrapper {
        width: 100%;
        margin-bottom: 20px;
    }

    .progress-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        z-index: 1;
        position: relative;
    }

    .steps {
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .steps .circle {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 50px;
        width: 50px;
        color: #999;
        font-size: 22px;
        font-weight: 500;
        border-radius: 50%;
        background: #fff;
        border: 4px solid #e0e0e0;
        transition: all 200ms ease;
        z-index: 2;
        /* Ensure circles are above the progress bar */
    }

    .steps .circle.active {
        border-color: #0B1E59;
        color: #0B1E59;
    }

    .steps .progress-bar {
        position: absolute;
        height: 4px;
        width: 100%;
        background: #e0e0e0;
        top: 50%;
        /* Align with the center of the circles */
        z-index: 1;
    }

    .progress-bar .indicator {
        position: absolute;
        height: 100%;
        width: 0%;
        background: #0B1E59;
        transition: all 300ms ease;
    }

    /* Separate Step Text Container */
    .step-text-container {
        display: flex;
        width: 100%;
        justify-content: space-between;
        margin-top: 10px;
        /* Space between progress bar and text */
    }

    .step-text {
        text-align: center;
        font-size: 15px;
        font-weight: 500;
        color: #666;
        /* width: 50px; */
        /* Ensure text aligns under the circle */
    }
</style>