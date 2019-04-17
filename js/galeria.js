function cambiarFotoGaleria(imgs) {
  let expandImg = document.getElementById("gal-expandedImg");
  let imgText = document.getElementById("gal-imgtext");
  expandImg.src = imgs.src;
  imgText.innerHTML = imgs.alt;
  expandImg.parentElement.style.display = "block";
}
