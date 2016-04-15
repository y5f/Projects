function sauvgarde(nomFichier,sig1,sig2,sig3)
fid = fopen(nomFichier,'w');
fprintf(fid,'%i ',sig1);
fprintf(fid,'\n');
fprintf(fid,'%i ',sig2);
fprintf(fid,'\n');
fprintf(fid,'%i ',sig3);
fprintf(fid,'\n');
fclose(fid);
end

