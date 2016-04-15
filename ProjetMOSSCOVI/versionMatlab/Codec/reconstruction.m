function sig_r = reconstruction(sig_s,diff_bits)
taille=length(sig_s);
taille_r=taille*8-diff_bits;
k=8;
for j=1:taille
    for i=0:7
        code_r(k-i)=fix(sig_s(j)/(2^(7-i)));
        if sig_s(j)>=2^(7-i)
            sig_s(j)=sig_s(j)-2^(7-i);
        end
    end
        k=k+8;
end
for i=1:taille_r
    sig_r(i)=code_r(i);
end
end