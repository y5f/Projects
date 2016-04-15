require 'socket'
class Reception
  @@ligne = 240
  @@colonne=320
  @@bloc = 8
  @@nbBloc=320/8*240/8
  @@client=TCPSocket.open('127.0.0.1',4000)
  def recevoir

    @yCbCr =Array.new(3){Array.new}



   k=1

     img= @@client.gets.split("[[")
     blocj=img[1].split("],")
     blocj[0]=blocj[0].split(", ")
     blocj[1]=blocj[1][2..-1].split(", ")
     blocj[2]=blocj[2][2...-3].split(", ")


   @tY = blocj[0].length
    for j in 0...@tY
      # Récuperation des valeurs des composantes Y du bloc bitstream
      @yCbCr[0][j] = blocj[0][j].to_i
    end
    # Récuperation de la taille du bloc bitstream des composantes Cb
    @tCb = blocj[1].length
    for j in 0...@tCb
      # Récuperation des valeurs des composantes Cb du bloc bitstream
     @yCbCr[1][j] = blocj[1][j].to_i
    end
    # Récuperation de la taille du bloc bitstream des composantes Cr
    @tCr = blocj[2].length
    for j in 0...@tCr
      # Récuperation des valeurs des composantes Cr du bloc bitstream
      @yCbCr[2][j] = blocj[2][j].to_i
    end
    k += 1

    #print blocj
    #print "\n"
  return @yCbCr
  end
end

