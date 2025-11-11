<?php
include 'db.php';

if (isset($_GET['id'])) {
    $manga_id = intval($_GET['id']);

    // --- Step 1: Delete chapter image folders ---
    $chapter_query = $conn->prepare("SELECT images_folder FROM chapters WHERE manga_id = ?");
    $chapter_query->bind_param("i", $manga_id);
    $chapter_query->execute();
    $chapter_result = $chapter_query->get_result();

    while ($chapter = $chapter_result->fetch_assoc()) {
        $folder = $chapter['images_folder'];
        if (is_dir($folder)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($files as $fileinfo) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }
            rmdir($folder);
        }
    }
    $chapter_query->close();

    // --- Step 2: Delete manga photo file ---
    $manga_query = $conn->prepare("SELECT photo FROM manga WHERE id = ?");
    $manga_query->bind_param("i", $manga_id);
    $manga_query->execute();
    $manga_result = $manga_query->get_result();
    if ($manga = $manga_result->fetch_assoc()) {
        $photo_path = $manga['photo'];
        if (!str_starts_with($photo_path, 'uploads/')) {
            $photo_path = 'uploads/' . $photo_path;
        }
        if (file_exists($photo_path)) {
            unlink($photo_path);
        }
    }
    $manga_query->close();

    // --- Step 3: Delete chapters from DB ---
    $del_chapters = $conn->prepare("DELETE FROM chapters WHERE manga_id = ?");
    $del_chapters->bind_param("i", $manga_id);
    $del_chapters->execute();
    $del_chapters->close();

    // --- Step 4: Delete manga record ---
    $del_manga = $conn->prepare("DELETE FROM manga WHERE id = ?");
    $del_manga->bind_param("i", $manga_id);
    $del_manga->execute();
    $del_manga->close();

    // --- Step 5: Remove manga folder (if exists) ---
    $manga_folder = "chapters/manga_" . $manga_id;
    if (is_dir($manga_folder)) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($manga_folder, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }
        rmdir($manga_folder);
    }

    // --- Step 6: Redirect back ---
    echo "<script>
        alert('✅ Manga and all its chapters have been deleted successfully.');
        window.location.href='deleteManga.php';
    </script>";
} else {
    echo "<script>
        alert('❌ No manga selected for deletion.');
        window.location.href='deleteManga.php';
    </script>";
}
?>
