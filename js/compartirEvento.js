function compartir(red, nombreEvento, imagenEvento) {
  let myWindow = window.open("", "MsgWindow" + red + nombreEvento + imagenEvento, "status=1, height=200, width=430");
  myWindow.document.write(
    "<html>" +
      "<head>" +
        "<title>Comparte este evento</title>" +
        "<link rel='stylesheet' type='text/css' href='/css/compartirPopUp.css'>" +
      "</head>" +
      "<body class='" + red + "'>" +
        "<h2>Comparte este evento en " + red + "</h2>" +
        "<form>" +
          "<div>" +
            "<input value='Echa un vistazo a " + nombreEvento + " en @MarioTennisClub' required>" +
            "</input>" +
            "<div>" +
              "<img width='250' src='img/" + imagenEvento + "'>" +
              "<br>" +
            "</div>" +
          "</div>" +
          "<button type='submit'>Compartir</button>" +
        "</form>" +
      "</body>" +
    "</html>"
  );
}
