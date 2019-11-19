<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .accordion {
            background-color: #4f0475;
            padding: 10px 15px;
            color: #fff;
            cursor: pointer;
            width: 100%;
            height: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 18px;
            border-radius: 5px;
            font-weight: 500;
            transition: 0.4s;
        }
        .active,
        .accordion:hover {
            background-color: #ccc;
            color: #4f0475;
        }

        .accordion:after {
            content: '\002B';
            color: #fff;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .panel {
            padding: 0 18px;
            background-color: #f5f5f580;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }
        .accordion_content{
            border-bottom: 2px solid #fff;
        }

    </style>
</head>

<body>
    <section class="container" style="margin-top:2%">
        <div class="accordion_content">
            <button class="accordion">Faqs Quistion 1</button>
            <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>

        <div class="accordion_content">
            <button class="accordion">Faqs Quistion 2</button>
            <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>

        <div class="accordion_content">
            <button class="accordion">Faqs Quistion 3</button>
            <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>
    </section>

    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>
</body>
</html>
