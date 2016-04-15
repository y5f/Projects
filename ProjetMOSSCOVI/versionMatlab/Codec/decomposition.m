function [m] = matrice_blocks(M,b,numBlock)
[l,c]=size(M);
m=zeros(b,b);
c_b=c/b;
ic_b=mod(numBlock,c_b);
il_b=floor(numBlock/c_b)+1;
if ic_b==0
    ic_b=c_b;
    il_b=il_b-1;
end
m=M((il_b-1)*b+1:il_b*b,(ic_b-1)*b+1:ic_b*b);
end
