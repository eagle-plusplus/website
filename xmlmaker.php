<?php
    include("database.php");

    // Select all data from the QUESTIONS table
    $sql1 = "SELECT title, qtext, qdate, uid FROM QUESTIONS";
    $result1 = mysqli_query($conn, $sql1);

    // Select all data from the ANSWERS table
    $sql2 = "SELECT atext, adate, uid FROM ANSWERS";
    $result2 = mysqli_query($conn, $sql2);

    // Check if there are rows in the QUESTIONS table
    if (mysqli_num_rows($result1) > 0) {
        // Create a new instance of XMLWriter
        $xml = new XMLWriter;
        $xml->openMemory();
        $xml->startDocument();
        $xml->setIndent(true);

        // Start the root element
        $xml->startElement("list");

        // Iterate over each row in the QUESTIONS table
        while ($row1 = mysqli_fetch_assoc($result1)) {
            // Start the 'question' element
            $xml->startElement("question");

            // Write the 'title' element
            $xml->startElement("title");
            $xml->writeRaw($row1["title"]);
            $xml->endElement();

            // Write the 'mainBody' element
            $xml->startElement("mainBody");
            $xml->writeRaw($row1["qtext"]);
            $xml->endElement();

            // Write the 'submitionDate' element
            $xml->startElement("submitionDate");
            $xml->writeRaw($row1["qdate"]);
            $xml->endElement();

            // Write the 'userID' element
            $xml->startElement("userID");
            $xml->writeRaw($row1["uid"]);
            $xml->endElement();

            // Start the 'answers' element
            $xml->startElement("answers");

            // Check if there are rows in the ANSWERS table
            if (mysqli_num_rows($result2) > 0) {
                // Iterate over each row in the ANSWERS table
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    // Start the 'answer' element
                    $xml->startElement("answer");

                    // Write the 'mainbody' element
                    $xml->startElement("mainbody");
                    $xml->writeRaw($row2["atext"]);
                    $xml->endElement();

                    // Write the 'submitionDate' element
                    $xml->startElement("submitionDate");
                    $xml->writeRaw($row2["adate"]);
                    $xml->endElement();

                    // Write the 'userID' element
                    $xml->startElement("userID");
                    $xml->writeRaw($row2["uid"]);
                    $xml->endElement();

                    // End the 'answer' element
                    $xml->endElement();
                }
            }

            // End the 'answers' element
            $xml->endElement();

            // End the 'question' element
            $xml->endElement();
        }

        // End the root element
        $xml->endElement();
        $xml->endDocument();

        $filename = "questions_answers.xml";

        // Set appropriate headers for download
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Output the generated XML
        echo $xml->outputMemory();
        exit();
    } else {
        echo "No data in database!";
    }

?>