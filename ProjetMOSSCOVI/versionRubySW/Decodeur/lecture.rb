class Lecture

  # Déclaration des attribus de la classe Lecture
  # Nombre de pixel ligne de l'image
  @@ligne = 256
  # Nombre de pixel colonne de l'image
  @@colonne = 256
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8
  # Nom du fichier texte qui contient les données de compression de l'image compressée
  @@nomFichier = "imageCompressee.txt"

  def lire
    # Calcule du nombre de blocs de l-image compressée
    nbBloc = @@ligne/@@bloc*@@colonne/@@bloc
    @yCbCr = Array.new(nbBloc) {Array.new(3) {Array.new}}
    # Lecture du fichier dans le tableau img
    img = IO.readlines(@@nomFichier)
    k=0
    for i in 0...nbBloc
      # Récuperation de la taille du bloc bitstream des composantes Y
      @tY = img[k].split(" ").length
      for j in 0...@tY
        # Récuperation des valeurs des composantes Y du bloc bitstream
        @yCbCr[i][0][j] = img[k].split(" ")[j].to_i
      end
      # Récuperation de la taille du bloc bitstream des composantes Cb
      @tCb = img[k+1].split(" ").length
      for j in 0...@tCb
        # Récuperation des valeurs des composantes Cb du bloc bitstream
        @yCbCr[i][1][j] = img[k+1].split(" ")[j].to_i
      end
      # Récuperation de la taille du bloc bitstream des composantes Cr
      @tCr = img[k+2].split(" ").length
      for j in 0...@tCr
        # Récuperation des valeurs des composantes Cr du bloc bitstream
        @yCbCr[i][2][j] = img[k+2].split(" ")[j].to_i
      end
      k += 3
    end
    return @yCbCr
  end

end