<?php
    include("database.php");

    $sql1 = "SELECT title, qtext, qdate, uid FROM QUESTIONS";
    $result1 = mysqli_query($conn, $sql1);

    $sql2 = "SELECT atext, adate, uid FROM ANSWERS";
    $result2 = mysqli_query($conn, $sql2);

    if (mysqli_num_rows($result1) > 0) {
        $xml = new XMLWriter;
        $xml->openMemory();
        $xml->startDocument();
        $xml->setIndent(true);

        $xml->startElement("list");
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $xml->startElement("question");
                $xml->startElement("title");
                $xml->writeRaw($row1["title"]);
                $xml->endElement();

                $xml->startElement("mainBody");
                $xml->writeRaw($row1["qtext"]);
                $xml->endElement();

                $xml->startElement("submitionDate");
                $xml->writeRaw($row1["qdate"]);
                $xml->endElement();

                $xml->startElement("userID");
                $xml->writeRaw($row1["uid"]);
                $xml->endElement();

                $xml->startElement("answers");

                    if (mysqli_num_rows($result2) > 0){
                        while ($row2 = mysqli_fetch_assoc($result2)){

                            $xml->startElement("answer");

                                $xml->startElement("mainbody");
                                $xml->writeRaw($row2["atext"]);
                                $xml->endElement();

                                $xml->startElement("submitionDate");
                                $xml->writeRaw($row2["adate"]);
                                $xml->endElement();

                                $xml->startElement("userID");
                                $xml->writeRaw($row2["uid"]);
                                $xml->endElement();

                            $xml->endElement();
                        }

                    }

                    $xml->endElement();

            $xml->endElement();
        }

        $xml->endElement();
        $xml->endDocument();

        $filename = "questions.xml";

        // Set appropriate headers for download
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Output the generated XML
        echo $xml->outputMemory();
        exit();

    } else {
        echo "No data in Database!";
    }
?>
