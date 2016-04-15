class Huffman

  def initialize(yDC=0, cbDC=0, crDC=0)
    @yDC = yDC
    @cbDC = cbDC
    @crDC = crDC
  end

  def coder(rle)
    yRLE = Array.new
    cbRLE = Array.new
    crRLE = Array.new
    @huffman = Array.new(3) {Array.new {Array.new} }
    @tY = rle[0].length
    tempYDC = rle[0][0]
    for i in 0...@tY
      yRLE[i] = rle[0][i]
    end
    @tCb = rle[1].length
    tempCBDC = rle[1][0]
    for i in 0...@tCb
      cbRLE[i] = rle[1][i]
    end
    @tCr = rle[2].length
    tempCRDC = rle[2][0]
    for i in 0...@tCr
      crRLE[i] = rle[2][i]
    end
    ydc = @yDC
    yH = calculH(yRLE, ydc)
    cbdc = @cbDC
    cbH = calculH(cbRLE, cbdc)
    crdc = @crDC
    crH = calculH(crRLE, crdc)
    @yDC = tempYDC
    @cbDC = tempCBDC
    @crDC = tempCRDC
    @huffman[0] = yH
    @huffman[1] = cbH
    @huffman[2] = crH
    return @huffman
  end

  def calculH(camposanteRLE, dc)
    octet = 8
    prefix = [[0, 0, 0], [0, 0, 1], [0, 1, 0], [0, 1, 1], [1, 0, 0], [1, 0, 1], [1, 1, 0], [1, 1, 1]]
    tPrefix = 3
    tRLE = camposanteRLE.length
    if tRLE == 4
      tRLE = 1
      else tRLE = tRLE-2
      end
    camposanteH = Array.new(tRLE) {Array.new}
    camposanteRLE[0] -= dc
    for i in 0...tRLE
      if tRLE == 1
        if camposanteRLE[i] >= 0
          for j in 0...octet
            camposanteH[i][octet-j-1] = camposanteRLE[0].modulo(2).to_i
            camposanteRLE[0] = camposanteRLE[0]/2.to_i
          end
        else
          for j in 0...octet
            camposanteRLE[i] = camposanteRLE[i].abs
            camposanteH[i][octet-j-1] = camposanteRLE[0].modulo(2).to_i
            camposanteH[i][octet-j-1] = (camposanteH[i][octet-j-1]+1).modulo(2)
            camposanteRLE[0] = camposanteRLE[0]/2.to_i
          end
        end
      else
        nbBits = 0
        if camposanteRLE[i] > 0
          nbBits = Math::log2(camposanteRLE[i]).to_i+1
          for j in tPrefix...nbBits+tPrefix
            camposanteH[i][nbBits+tPrefix+tPrefix-j-1] = camposanteRLE[i].modulo(2).to_i
            camposanteRLE[i] = camposanteRLE[i]/2.to_i
          end
        elsif camposanteRLE[i] < 0
           camposanteRLE[i] = camposanteRLE[i].abs
           nbBits = Math::log2(camposanteRLE[i]).to_i+1
           for j in tPrefix...nbBits+tPrefix
             camposanteH[i][nbBits+tPrefix+tPrefix-j-1] = camposanteRLE[i].modulo(2).to_i
             camposanteH[i][nbBits+tPrefix+tPrefix-j-1] = (camposanteH[i][nbBits+tPrefix+tPrefix-j-1]+1).modulo(2)
             camposanteRLE[i] = camposanteRLE[i]/2.to_i
           end
        end
        for k in 0...tPrefix
          camposanteH[i][k] = prefix[nbBits][k]
        end
      end
    end
    return camposanteH
  end

end