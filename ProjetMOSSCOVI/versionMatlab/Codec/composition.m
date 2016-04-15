function M = composition(M,m,numBlock)
[ligne_m,colonne_m]=size(m);
[ligne_M,colonne_M]=size(M);
c_b = colonne_M/colonne_m;
l=floor(numBlock/c_b)+1;
c = mod(numBlock,c_b);
if c==0
    c = c_b;
    l=l-1;
end
M(((l-1)*ligne_m)+1:l*ligne_m, ((c-1)*colonne_m)+1:c*colonne_m) = m/255;
end

