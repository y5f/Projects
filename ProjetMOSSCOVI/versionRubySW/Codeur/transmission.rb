require 'socket'
class Transmission

  def transmettre(bs,client)
    # Ouverture du fichier texte qui contiendera les données compressées de l'image
    client.write bs





    # Récuperation de la taille du bloc bitstream des composantes Y
   # @tY = bs[0].length
    #for i in 0...@tY
      # Ecriture du bloc bitstream des composantes Y dans le fichier texte
     # client.puts bs[0][i]
    #end
    # Récuperation de la taille du bloc bitstream des composantes Cb
    #@tCb = bs[1].length
    #for i in 0...@tCb
      # Ecriture du bloc bitstream des composantes Cb dans le fichier texte
     # client.puts bs[1][i]
    #end

    # Récuperation de la taille du bloc bitstream des composantes Cr
    #@tCr = bs[2].length
    #for i in 0...@tCr
      # Ecriture du bloc bitstream des composantes Cr dans le fichier texte
     # client.puts bs[2][i]
    #end

  end

end

