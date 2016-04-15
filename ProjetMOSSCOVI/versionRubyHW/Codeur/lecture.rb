require_relative 'pixel'

class Lecture < Reactiv

  # Déclaration des attribus de la classe Lecture
  # Port de sortie
  outports :s

  # Nombre de pixel ligne de l'image
  LIGNE = 384
  # Nombre de pixel colonne de l'image
  COLONNE = 512
  # Nom du fichier texte qui contient les valeurs des pixels "R, G, B" de l'image
  FICHIER = "imageRGB.txt"

  def behavior
    # Lecture du fichier dans le tableau img
    img = IO.readlines(FICHIER)
    k = 0
    for i in 0...LIGNE
      for j in 0...COLONNE
        # Récuperation de la valeur du pixel rouge
        r = img[k].split(" ")[0].to_i
        # Récuperation de la valeur du pixel vert
        g = img[k].split(" ")[1].to_i
        # Récuperation de la valeur du pixel bleu
        b = img[k].split(" ")[2].to_i
        # Creation du pixel avec les valeurs des couleurs rouges, verts et bleux
        pixel = Pixel.new(r, g, b)
        # Envoie du pixel "R, G, B" dans le port de sortie s
        @s.send(pixel)
        k += 1
      end
    end
  end

end