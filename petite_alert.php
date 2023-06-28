 <?php

 // L'animation a été inspiré d'une Vidéo de BENJAMEN CODE sur Youtube. On a vu que c'était sympa de compenser l'attente de l'utilisateur avec une petite animation CSS.
    function alert($extension,$background,$titre, $message, $url_de_sortie) {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout</title>
    <style>
             
            .alert {
        padding: 20px;
        background : #FFBD99;
        color: white;
        border-radius:10px;
        display:flex;
        width:65vw;
        height:60vh;
        }
        .animation {
            margin : 3vw;
            background: url("<?=$extension?>/medias/images/Logo.png") ;
            background-size : contain;
            background-repeat : no-repeat;
            background-position : center;
            
        }

        .alertt {
            padding:2vh;
            text-align:center;
            width : 30vw;
            background:#8F3D4C;
            border-radius:2vh;
            margin:auto;
        }
        h2 {
            text-decoration: underline;
            shadow:3px 1px 0px 2px;
        }

        strong {
            font-size:30px;
        }
        * {
	border: 0;
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}
:root {
	font-size: calc(16px + (20 - 16) * (100vw - 320px) / (1280 - 320));
}
body {
	background-color: hsl(223, 90%, 95%);
	font: 1em/1.5 sans-serif;
	height: 90vh;
	display: grid;
	place-items: center;
}
.pl,
.pl__ball,
.pl__ball-inner-shadow,
.pl__ball-side-shadows,
.pl__ball-texture,
.pl__inner-ring,
.pl__outer-ring,
.pl__track-cover {
	border-radius: 50%;
}
.pl {
	position: relative;
	width: 16em;
	height: 16em;
}
.pl__ball,
.pl__ball-inner-shadow,
.pl__ball-outer-shadow,
.pl__ball-side-shadows,
.pl__ball-texture,
.pl__ball-texture:before,
.pl__inner-ring,
.pl__outer-ring,
.pl__track-cover {
	position: absolute;
}
.pl__ball,
.pl__ball-inner-shadow,
.pl__ball-outer-shadow,
.pl__ball-texture:before,
.pl__track-cover {
	animation: ball 3s linear infinite;
}
.pl__ball {
	top: calc(50% - 1.25em);
	left: calc(50% - 1.25em);
	transform: rotate(0) translateY(-6.5em);
	width: 2.5em;
	height: 2.5em;
}
.pl__ball-inner-shadow {
	animation-name: ballInnerShadow;
	box-shadow:
		0 0.1em 0.2em hsla(0, 0%, 0%, 0.3),
		0 0 0.2em hsla(0, 0%, 0%, 0.1) inset,
		0 -1em 0.5em hsla(0, 0%, 0%, 0.15) inset;
	width: 100%;
	height: 100%;
}
.pl__ball-outer-shadow {
	animation-name: ballOuterShadow;
	background-image: linear-gradient(hsla(0, 0%, 0%, 0.15),hsla(0, 0%, 0%, 0));
	border-radius: 0 0 50% 50% / 0 0 100% 100%;
	filter: blur(2px);
	top: 50%;
	left: 0;
	width: 100%;
	height: 250%;
	transform: rotate(20deg);
	transform-origin: 50% 0;
	z-index: -2;
}
.pl__ball-side-shadows {
	background-color: #FFBD99;
	filter: blur(2px);
	width: 100%;
	height: 100%;
	transform: scale(0.75,1.1);
	z-index: -1;
}
.pl__ball-texture {
	overflow: hidden;
	width: 100%;
	height: 100%;
	transform: translate3d(0,0,0);
}
.pl__ball-texture:before {
	animation-name: ballTexture;
	animation-duration: 0.25s;
	background: url("./medias/images/boule.svg") 0 0 / 50% 100%;
	content: "";
	display: block;
	filter: brightness(1.05);
	top: 0;
	right: 0;
	width: 200%;
	height: 100%;
}
.pl__inner-ring {
	box-shadow:
		0 -0.25em 0.5em hsla(0, 0%, 100%, 0.4),
		0 0.5em 0.75em hsla(0, 0%, 100%, 0.4) inset,
		0 0.5em 0.375em hsla(0, 0%, 0%, 0.15),
		0 -0.5em 0.75em hsla(0, 0%, 0%, 0.15) inset;
	top: 2.375em;
	left: 2.375em;
	width: calc(100% - 4.75em);
	height: calc(100% - 4.75em);
}
.pl__outer-ring {
	box-shadow:
		0 -0.45em 0.375em hsla(0, 0%, 0%, 0.15),
		0 0.5em 0.75em hsla(0, 0%, 0%, 0.15) inset,
		0 0.25em 0.5em hsla(0, 0%, 100%, 0.4),
		0 -0.5em 0.75em hsla(0, 0%, 100%, 0.4) inset;
	top: 0.75em;
	left: 0.75em;
	width: calc(100% - 1.5em);
	height: calc(100% - 1.5em);
}
.pl__track-cover {
	animation-name: trackCover;
	background-image: conic-gradient(hsla(#FFBD99, 1) 210deg, hsla(#FFBD99, 0) 270deg);
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}

/* Animations */
@keyframes ball {
	from {
		transform: rotate(0) translateY(-6.5em);
	}
	50% {
		transform: rotate(180deg) translateY(-6em);
	}
	to {
		transform: rotate(360deg) translateY(-6.5em);
	}
}
@keyframes ballInnerShadow {
	from {
		transform: rotate(0);
	}
	to {
		transform: rotate(-360deg);
	}
}
@keyframes ballOuterShadow {
	from {
		transform: rotate(20deg);
	}
	to {
		transform: rotate(-340deg);
	}
}
@keyframes ballTexture {
	from {
		transform: translateX(0);
	}
	to {
		transform: translateX(50%);
	}
}
@keyframes trackCover {
	from {
		transform: rotate(0);
	}
	to {
		transform: rotate(360deg);
	}
}
        </style>
</head>
<body>
    <div class="alert">
        <div class="animation">
            <div class="pl">
                <div class="pl__outer-ring"></div>
                <div class="pl__inner-ring"></div>
                <div class="pl__track-cover"></div>
                <div class="pl__ball">
                    <div class="pl__ball-texture"></div>
                    <div class="pl__ball-outer-shadow"></div>
                    <div class="pl__ball-inner-shadow"></div>
                    <div class="pl__ball-side-shadows"></div>
                </div>
            </div>
        </div>

        <div class="alertt">
            <h2 style="text-align:center; ">Alert </h2>
            <br>
            <h4 style="text-align:left;">Objet: <span style="background:<?=$background?>; padding:5px;"> <?=$titre?> </span></h4>
            <br>
            <p style="text-align:left; margin-left: 3vw;"><?=$message?></p>
        </div>
        
    </div>
        <script>
                    function laSortie() {
        window.location= "<?= $url_de_sortie?>"
        }
         const myTimeout = setTimeout(laSortie, 5000);
</script>
</body>
</html>
       <?php
    }
  