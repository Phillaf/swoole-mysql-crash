
for i in {1..10}
do
    echo "attempt $i:"
    URL="http://localhost/$i"
    echo "$(curl --silent $URL)"
    sleep 1
done
