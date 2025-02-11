<style type="text/css">
.header {
    /* border-bottom: 1px double #e86100; */
    width: 100%;
    /* height: 60px; */
    /* margin-top: 0px; */
    text-align: center;
}

.header h3 {
    margin-top: 0;
    margin-bottom: 5px;
    font-size: 40px;
    font-weight: bold;
    font-style: italic;
    text-align: center;
    color: #a30bf1;
}

.img {
    width: 500px;
    /* margin-top: 0px; */
    /*border: 1px solid;*/
}

.section3 {
    /*border: 1px solid;*/
    height: 130px;
}

.section4 {
    height: 130px;
    margin-bottom: 15px;
}

.section12 {
    height: 110px;
    width: 100%;
    margin-top: 5px;
    border-radius: 5px;
}

.section12 .logo {
    /*border: 1px solid;*/
    height: 30px;
    width: 100%;
    font-size: 40px;
    text-align: center;
    margin-top: 5px;
}

.section12 .textModule {
    height: auto;
    width: 100%;
    margin-top: 20px;
    font-weight: bold;
    font-size: 14px;
    color: #000;
    text-align: center;
}

.section122 {
    height: 130px;
    width: 100%;
    margin-top: 5px;
    border-radius: 5px;
    background-color: #0d333b;
    border: 1px solid #ccc;
    padding: 0px;
}

.section122 .logo {
    /*border: 1px solid;*/
    height: 75px;
    width: 100%;
    font-size: 60px;
    text-align: center;
    margin-top: 5px;
}

.section122 .textModule {
    height: auto;
    width: 100%;
    margin-top: 15px;
    font-weight: bold;
    font-size: 17px;
    color: #000;
    /* color: #fff; */
    text-align: center;
}

.section20 {
    height: 90px;
    width: 100%;
    margin-bottom: 20px;
    border-radius: 5px;
}

.section20 .logo {
    height: 50px;
    width: 100%;
    font-size: 40px;
    text-align: center;
    margin-top: 5px;
    color: #FFF;
}

.section20 .textModule {
    height: auto;
    width: 100%;
    margin-top: 10px;
    font-weight: bold;
    font-size: 12px;
    /* color: #000; */
    color: #eee;
    text-align: center;
}

.banner_img {
    padding: 15px 0;
}

.txtBody {
    height: auto;
    width: 100%;
    margin-top: 5px;
    font-weight: bold;
    font-size: 70px;
    color: #1A7EB0;
    text-align: center;
}

/* a {
    color: #fff;
} */

.module_title {
    background-color: #14c1f7 !important;
    text-align: center;
    font-size: 18px !important;
    font-weight: bold;
    font-style: italic;
    color: #000 !important;
}

@media only screen and (max-width: 600px) {
    .section122 .textModule {
        font-size: 15px;
    }

    .page-content {
        padding: 8px 0px 24px;
    }
}

@keyframes FadeIn {
    0% {
        opacity: 0;
        transform: scale(.1);
    }

    85% {
        opacity: 1;
        transform: scale(1.05);
    }

    100% {
        transform: scale(1);
    }
}

/* .myClass img {
   float: left;
   margin: 20px;
   animation: FadeIn 1s linear;
   animation-fill-mode: both;
} */


.ser_mod {
    animation: FadeIn .3s linear;
}

.section12,
.section20 {
    /* background: #a8ff78; */
    transition: 1s;
    background: -webkit-linear-gradient(to right, #78ffd6, #a8ff78);
    /* background: linear-gradient(to right, #000000, #0d333b); */
    background: linear-gradient(90deg, #002f4c 0%, #0d333b 100%);
    /* border-left: 5px solid #e53d01; */
    /* border-right: 5px solid #e53d01; */
    /* background: #a8ff78; */
    /* fallback for old browsers */
    /* background: -webkit-linear-gradient(to right, #78ffd6, #a8ff78); */
    /* Chrome 10-25, Safari 5.1-6 */
    /* background: linear-gradient(to right, #78ffd6, #a8ff78); */
    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    /*linear-gradient(to right, #b0baef, #ff81d8)*/
    /*#78ffd6, #a8ff78);*/
    padding: 0;
}

.section12,
.section20:hover {
    scale: 103%;
    transition: .3s;
    box-shadow: 1px 0px 15px;
    /* background: #7c2100; */
    /* border-left: 5px solid #e53d01; */
    /* border-right: 5px solid #e53d01; */
    /* background: #a8ff78; */
    /* fallback for old browsers */
    /* background: -webkit-linear-gradient(to right, #78ffd6, #a8ff78); */
    /* Chrome 10-25, Safari 5.1-6 */
    /* background: linear-gradient(to right, #78ffd6, #a8ff78); */
    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    /*linear-gradient(to right, #b0baef, #ff81d8)*/
    /*#78ffd6, #a8ff78);*/
}
</style>