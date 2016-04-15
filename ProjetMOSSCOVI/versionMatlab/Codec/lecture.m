function [sig1, sig2, sig3] = lecture(nomFichier, numBlock)
sig=load(nomFichier);
sig1=sig((numBlock-1)*3+1,:)
sig2=sig((numBlock-1)*3+2,:)
sig3=sig((numBlock-1)*3+3,:)
end

