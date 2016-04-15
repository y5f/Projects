class Sauvegarde < Reactiv

  # Déclaration des attribus de la classe Sauvegarde
  # Port d'entrée
  inports :e

  # Nombre de pixel ligne de l'image
  LIGNE = 384
  # Nombre de pixel colonne de l'image
  COLONNE = 512
  # Nombre de pixel ligne du bloc de l'image
  BLOC = 8

  def behavior
    # Ouverture du fichier texte qui contiendera les données compressées de l'image
    f = File.new('imageCompressee.txt', 'a')
    # Nombre de blocs ligne
    nbBlocLigne = LIGNE/BLOC
    # Nombre de blocs colonne
    nbBlocColonne = COLONNE/BLOC
    # Calcule du nombre de blocs de l'image
    nbBloc = nbBlocLigne*nbBlocColonne
    for numBloc in 0...nbBloc
      # Récuperation de la taille du bloc bitstream des composantes Y
      tY = @e.receive
      for i in 0...tY
        # Ecriture du bloc bitstream des composantes Y dans le fichier texte
        f.print "#{@e.receive} "
      end
      f.print "\n"
      # Récuperation de la taille du bloc bitstream des composantes Cb
      tCb = @e.receive
      for i in 0...tCb
        # Ecriture du bloc bitstream des composantes Cb dans le fichier texte
        f.print "#{@e.receive} "
      end
      f.print "\n"
      # Récuperation de la taille du bloc bitstream des composantes Cr
      tCr = @e.receive
      for i in 0...tCr
        # Ecriture du bloc bitstream des composantes Cr dans le fichier texte
        f.print "#{@e.receive} "
      end
      f.print "\n"
    end
    # Fermeture du fichier texte
    f.close
  end

end