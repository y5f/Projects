function Mn = reseize(M,block)
[ligne,colonne]=size(M);
if mod(ligne,block)==0 || mod(ligne,block)>=(block/2)
    Nblock_ligne=round(ligne/block);
else if mod(ligne,block)<(block/2)
    Nblock_ligne=round(ligne/block)+1;
    end 
end
if mod(colonne,block)==0 || mod(colonne,block)>=(block/2)
    Nblock_colonne=round(colonne/block);
else if mod(colonne,block)<(block/2)
    Nblock_colonne=round(colonne/block)+1;
    end
end
Mn=zeros(block*Nblock_ligne,block*Nblock_colonne);
for i=1:ligne
    for j=1:colonne
        Mn(i,j)=M(i,j);
    end
end
end