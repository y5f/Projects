require 'opencv'
include OpenCV
class IDCT

  # Déclaration des attribus de la classe IDCT
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8

  def itransformer(iq)

    yiDct = CvMat.new(8,8,CV_32FC1,1)
    criDct =CvMat.new(8,8,CV_32FC1,1)
    cbiDct =CvMat.new(8,8,CV_32FC1,1)

    temp=iq.split()
    yiDct=temp[0]
    criDct=temp[1]
    cbiDct= temp[2]

    yiDct=   yiDct.dct(CV_DXT_INVERSE)
    criDct= criDct.dct(CV_DXT_INVERSE)
    cbiDct= cbiDct.dct(CV_DXT_INVERSE)


    [yiDct,criDct,cbiDct]


  end



end