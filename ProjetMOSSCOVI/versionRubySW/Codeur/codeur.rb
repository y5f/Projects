require_relative 'conversion'
require_relative 'mcu'
require_relative 'dct'
require_relative 'quantification'
require_relative 'zigzag'
require_relative 'rle'
require_relative 'huffman'
require_relative 'bit_stream'
require_relative 'transmission'
require 'opencv'
require 'socket'
include OpenCV

class Codeur

  @@ligne = 240
  @@colonne = 320
  @@bloc = 8
  mcu = MCU.new
  dct=DCT.new
  conversion=Conversion.new
  quantification = Quantification.new
  zigzag = Zigzag.new
  rle = RLE.new
  huffman = Huffman.new
  bitStream = BitStream.new
  transmission = Transmission.new
  nbBloc = @@ligne/@@bloc*@@colonne/@@bloc
  #@yCrCb=conversion.convertir @rgb
  server=TCPServer.new 4000
  client=server.accept
  frames=CvCapture.open 0
  frames.size =CvSize.new(320,240)
  @rgb=Array.new(20){Array.new}

  for k in 0...20
    @rgb[k]=frames.query
  end

  for  n in 0...20
    puts n
    #@rgb=CvMat.load("../images/peppers.png")
    

    @yCrCb=@rgb[n].BGR2YCrCb

    for numBloc in 0...nbBloc


    @blocYCrCb = mcu.decomposer(@yCrCb, numBloc)

    @dctY,@dctCr,@dctCb = dct.transformer(@blocYCrCb)



    @blocQ= quantification.quantifier(@dctY,@dctCr,@dctCb)
    @blocZ = zigzag.balayer(@blocQ)
    #for i in 0...64
     #  print "#{@blocZ[i][0]} "
    #end
    #print "\n"
    @blocRLE = rle.coder(@blocZ)
    #print @blocRLE
   # print "\n"
    @blocH = huffman.coder(@blocRLE)
    @blocBS = bitStream.serialiser(@blocH)


    client.puts  "#{@blocBS}\n"
    end


end

end