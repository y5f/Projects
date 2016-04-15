class Conversion < Reactiv

  # Déclaration des attribus de la classe Conversion
  # Port d'entrée
  inports :e
  # Port de sortie
  outports :s

  # Nombre de pixel ligne de l'image
  LIGNE = 384
  # Nombre de pixel colonne de l'image
  COLONNE = 512

  def behavior
    for i in 0...LIGNE
      for j in 0...COLONNE
        # Reception du pixel "R, G, B" dans le port d'entré e
        pixel = @e.receive
        # Calcule de la composante Y à partir des valeurs des pixels "R, G, B" de l'image
        y = (0.257*pixel.getR+0.504*pixel.getG+0.098*pixel.getB+16).round
        # Calcule de la composante Cb à partir des valeurs des pixels "R, G, B" de l'image
        cb = (-0.148*pixel.getR-0.291*pixel.getG+0.439*pixel.getB+128).round
        # Calcule de la composante Cr à partir des valeurs des pixels "R, G, B" de l'image
        cr = (0.439*pixel.getR-0.368*pixel.getG-0.071*pixel.getB+128).round
        # Récuperation de la composantes Y
        pixel.setR(y)
        # Récuperation de la composantes Y
        pixel.setG(cb)
        # Récuperation de la composantes Y
        pixel.setB(cr)
        # Envoie des composantes "Y, Cb, Cr" dans le port de sortie s
        @s.send(pixel)
      end
    end
  end

end