class IBitStream

  def iserialiser(yCbCr)
    y = Array.new
    cb = Array.new
    cr = Array.new
    @ibs = Array.new(3) {Array.new}
    @tY = yCbCr[0].length
    for i in 0...@tY
      y[i] = yCbCr[0][i]
    end
    @tCb = yCbCr[1].length
    for i in 0...@tCb
      cb[i] = yCbCr[1][i]
    end
    @tCr = yCbCr[2].length
    for i in 0...@tCr
      cr[i] = yCbCr[2][i]
    end
    yIBS = calculIBS(y)
    @tY = yIBS.length
    for i in 0...@tY
      @ibs[0][i] = yIBS[i]
    end
    cbIBS = calculIBS(cb)
    @tCb = cbIBS.length
    for i in 0...@tCb
      @ibs[1][i] = cbIBS[i]
    end
    crIBS = calculIBS(cr)
    @tCr = crIBS.length
    for i in 0...@tCr
      @ibs[2][i] = crIBS[i]
    end
    return @ibs
  end

  def calculIBS(composante)
    octet = 8
    debut = 0
    k = 0
    nbOctets = composante.length
    nbBits = nbOctets*octet
    composanteBitIBS = Array.new(nbBits)
    for i in 0...nbOctets
      msb = octet*(i+1)
      for j in 0...octet
        composanteBitIBS[msb-j-1] = composante[i].modulo(2).to_i
        composante[i] = composante[i]/2.to_i
      end
    end
    if nbOctets != 1
      debut = 3
      s = 0
      for i in 0...debut
        s = s+(composanteBitIBS[i]*(2**(debut-i-1)))
      end
      debut += s
      k = 0
      while composanteBitIBS[k+debut] != 1
        k += 1
      end
      k -= 2
    end
    composanteIBS = Array.new(nbBits-k)
    for i in 0...debut
      composanteIBS[i] = composanteBitIBS[i]
    end
    for i in debut...nbBits-k
      composanteIBS[i] = composanteBitIBS[i+k]
    end
    return composanteIBS
  end

end