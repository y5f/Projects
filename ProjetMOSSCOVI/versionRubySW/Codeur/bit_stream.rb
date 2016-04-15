class BitStream

  def serialiser(huffman)
    yH = Array.new {Array.new}
    cbH = Array.new {Array.new}
    crH = Array.new {Array.new}
    @bs = Array.new(3) {Array.new}
    @tY = huffman[0].length
    for i in 0...@tY
      yH[i] = huffman[0][i]
    end
    @tCb = huffman[1].length
    for i in 0...@tCb
      cbH[i] = huffman[1][i]
    end
    @tCr = huffman[2].length
    for i in 0...@tCr
      crH[i] = huffman[2][i]
    end
    yBS = calculBS(yH)
    @tY = yBS.length
    for i in 0...@tY
      @bs[0][i] = yBS[i]
    end
    cbBS = calculBS(cbH)
    @tCb = cbBS.length
    for i in 0...@tCb
      @bs[1][i] = cbBS[i]
    end
    crBS = calculBS(crH)
    @tCr = crBS.length
    for i in 0...@tCr
      @bs[2][i] = crBS[i]
    end
    return @bs
  end

  def calculBS(composanteH)
    octet = 8
    @tH = composanteH.length
    nbBits = 0
    for i in 0...@tH
      nbBits = nbBits+composanteH[i].length
    end
    if nbBits != octet
      diffBits = 0
      if nbBits.modulo(octet) != 0
        diffBits = octet-nbBits.modulo(8)
        nbBits = nbBits+diffBits
      end
    end
    nbOctets = nbBits/octet
    composanteBitS = Array.new(nbBits)
    composanteS = Array.new(nbOctets)
    if nbOctets == 1
      s = 0
      for i in 0...octet
        s = s+composanteH[0][octet-i-1]*(2**i)
      end
      composanteS[0] = s
    else
      k = 0
      for i in 0...composanteH[0].length
        composanteBitS[k] = composanteH[0][i]
        k = k+1
      end
      if diffBits != 0
        for i in k...k+diffBits
          composanteBitS[i] = 0
        end
      end
      k += diffBits
      for i in 1...@tH
        for j in 0...composanteH[i].length
          composanteBitS[k] = composanteH[i][j]
          k = k+1
        end
      end
      k = 0
      for i in 0...nbOctets
        s = 0
        for j in 0...octet
          s = s+(composanteBitS[k+octet-j-1]*(2**j))
        end
        composanteS[i] = s
        k = k+octet
      end
    end
    return composanteS
  end

end