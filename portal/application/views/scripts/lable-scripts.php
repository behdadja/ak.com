<style>
    .bg-image {

        /* Add the blur effect */
        filter: blur(8px);
        -webkit-filter: blur(8px);

        /* Full height */
        height: 100%;

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        text-align: center;
        opacity:.40;
    }

    /* Position text in the middle of the page/image */
    .bg-text {
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0, 0.4); /* Black w/opacity/see-through */
        color: white;
        font-weight: bold;
        border: 3px solid #f1f1f1;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        width: 80%;
        padding: 10px;
    }
    .bg{
        border: 3px solid #f1f1f1;
        height: 120px;
        width: 120px
    }
    .b{
        font-size: 20px;
        color: white;
    }
    .box{
        margin: 15px 0 15px 0;
    }
    .box div{
        text-align: center;
        padding: 15px;
        border-radius: 0 0 10px 0;
        box-shadow: 1px 1px 1px;
        background-color: white
    }
    .input {
        border: 0;
    }
</style>