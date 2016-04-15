class IConversion < Reactiv

  # Déclaration des attribus de la classe IConversion
  # Port d'entrée
  inports :e
  # Port de sortie
  outports :s

  # Nombre de pixel ligne de l'image
  LIGNE = 384
  # Nombre de pixel colonne de l'image
  COLONNE = 512

  def behavior
    @rgb = Array.new(@@ligne) {Array.new(@@colonne)}
    for i in 0...LIGNE
      for j in 0...COLONNE
        pixel = @e.receive
        # Calcule de la valeur du pixel rouge à partir des composantes "Y, Cb, Cr" de l'image
        r = (1.164*(pixel.getR-16)+1.596*(pixel.getB-128)).round
        # Calcule de la valeur du pixel vert à partir des composantes "Y, Cb, Cr" de l'image
        g = (1.164*(pixel.getR-16)-0.392*(pixel.getG-128)-0.813*(pixel.getB-128)).round
        # Calcule de la valeur du pixel bleu à partir des composantes "Y, Cb, Cr" de l'image
        b = (1.164*(pixel.getR-16)+2.017*(pixel.getG-128)).round
        # Récuperation de la valeur du pixel rouge
        pixel.setR(r)
        # Récuperation de la valeur du pixel vert
        pixel.setG(g)
        # Récuperation de la valeur du pixel bleu
        pixel.setB(b)
        @s.send(pixel)
      end
    end
  end

end