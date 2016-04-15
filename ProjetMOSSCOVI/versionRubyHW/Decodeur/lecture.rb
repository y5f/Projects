class Lecture < Reactiv

  # Déclaration des attribus de la classe Lecture
  # Port de sortie
  outports :s

  # Nombre de pixel ligne de l'image
  LIGNE = 384
  # Nombre de pixel colonne de l'image
  COLONNE = 512
  # Nom du fichier texte qui contient les données de compression de l'image compressée
  FICHIER = "imageCompressee.txt"

  def behavior
    # Calcule du nombre de blocs de l-image compressée
    nbBloc = @@ligne/@@bloc*@@colonne/@@bloc
    # Lecture du fichier dans le tableau img
    img = IO.readlines(@@nomFichier)
    k=0
    for i in 0...nbBloc
      # Récuperation de la taille du bloc bitstream des composantes Y
      tY = img[k].split(" ").length
      @s.send(tY)
      for j in 0...tY
        # Récuperation des valeurs des composantes Y du bloc bitstream
        y = img[k].split(" ")[j].to_i
        @s.send(y)
      end
      # Récuperation de la taille du bloc bitstream des composantes Cb
      tCb = img[k+1].split(" ").length
      @s.send(tCb)
      for j in 0...tCb
        # Récuperation des valeurs des composantes Cb du bloc bitstream
        cb = img[k+1].split(" ")[j].to_i
        @s.send(cb)
      end
      # Récuperation de la taille du bloc bitstream des composantes Cr
      tCr = img[k+2].split(" ").length
      @s.send(tCr)
      for j in 0...tCr
        # Récuperation des valeurs des composantes Cr du bloc bitstream
        cr = img[k+2].split(" ")[j].to_i
        @s.send(cr)
      end
      k += 3
    end
  end

end