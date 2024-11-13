<?php
    // Include the configuration file
    include 'includes/config.php';

    // Connect to the database
    $conn = connectDB();

    // Fetch the number of macOS versions
    $macos_count_sql = "SELECT COUNT(*) as count FROM macos_versions";
    $macos_count_result = $conn->query($macos_count_sql);
    $macos_count = $macos_count_result->fetch_assoc()['count'];

    // Fetch all macOS versions sorted by release date
    $macos_versions_sql = "
      SELECT version_name, release_name, darwin_os_number, date_announced, date_released, latest_release_date
      FROM macos_versions
      ORDER BY date_released";
    $macos_versions_result = $conn->query($macos_versions_sql);

    // Fetch macOS versions with release year
    $macos_versions_year_sql = "
      SELECT version_name, release_name, YEAR(date_released) AS release_year
      FROM macos_versions
      ORDER BY date_released";
    $macos_versions_year_result = $conn->query($macos_versions_year_sql);

    // Fetch current inventory (active status)
    $inventory_sql = "
      SELECT model, model_identifier, model_number, part_number, serial_number, darwin_os_number,
             latest_supporting_darwin_os_number, url
      FROM computer_inventory
      WHERE status = 'active'";
    $inventory_result = $conn->query($inventory_sql);

    // Fetch the Installed/Original OS and Last Supported OS for the Current Inventory
    $inventory_os_sql = "
      SELECT ci.model, mv1.release_name AS original_os, mv2.release_name AS last_supported_os
      FROM computer_inventory ci
      JOIN macos_versions mv1 ON ci.darwin_os_number = mv1.darwin_os_number
      JOIN macos_versions mv2 ON ci.latest_supporting_darwin_os_number = mv2.darwin_os_number
      WHERE ci.status = 'active'";
    $inventory_os_result = $conn->query($inventory_os_sql);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Apple Macintosh Computer Inventory</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,200;0,500;1,200;1,500&display=swap">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <header>
      <h1>Apple Macintosh Computer Inventory</h1>
    </header>

    <section>
      <h2>How Many Versions of macOS Have Been Released?</h2>
      <div>
        <p>There have been <b><?php echo $macos_count; ?></b> versions of macOS released thus far.</p>
      </div>
    </section>

    <!-- macOS Versions Detailed Table -->
    <section>
      <h2>Show the Version Name, Release Name, Official Darwin OS Number, Date Announced, Date Released, and Date of Latest Release of All macOS Versions, Listed by Date Order</h2>
      <div>
        <table>
          <thead>
            <tr>
              <th>Version Name</th>
              <th>Release Name</th>
              <th>Official Darwin OS Number</th>
              <th>Date Announced</th>
              <th>Date Released</th>
              <th>Latest Release Date</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $macos_versions_result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['version_name']); ?></td>
                <td><?php echo htmlspecialchars($row['release_name']); ?></td>
                <td><?php echo htmlspecialchars($row['darwin_os_number']); ?></td>
                <td><?php echo htmlspecialchars($row['date_announced']); ?></td>
                <td><?php echo htmlspecialchars($row['date_released']); ?></td>
                <td><?php echo htmlspecialchars($row['latest_release_date']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- macOS Versions with Release Year -->
    <section>
      <h2>Show the Version Name (Release Name) and Year Released of All macOS Versions, Listed by Date Released</h2>
      <div>
        <table>
          <thead>
            <tr>
              <th>Version Name (Release Name)</th>
              <th>Year Released</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $macos_versions_year_result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['version_name'] . " (" . $row['release_name'] . ")"); ?></td>
                <td><?php echo htmlspecialchars($row['release_year']); ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Current Inventory Table -->
    <section>
      <h2>Show the Current Inventory (Excluding Comments)</h2>
      <div>
        <table>
          <thead>
            <tr>
              <th>Model Name</th>
              <th>Model Identifier</th>
              <th>Model Number</th>
              <th>Part Number</th>
              <th>Serial Number</th>
              <th>Darwin OS Number</th>
              <th>Latest Supporting Darwin OS Number</th>
              <th>URL</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $inventory_result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['model']); ?></td>
                <td><?php echo htmlspecialchars($row['model_identifier'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['model_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['part_number']); ?></td>
                <td><?php echo htmlspecialchars($row['serial_number']); ?></td>
                <td><?php echo htmlspecialchars($row['darwin_os_number']); ?></td>
                <td><?php echo htmlspecialchars($row['latest_supporting_darwin_os_number']); ?></td>
                <td><a href="<?php echo htmlspecialchars($row['url'] ?? ''); ?>">Link</a></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Installed/Original and Last Supported OS -->
    <section>
      <h2>Show the Model, Installed/Original OS, and the Last Supported OS For the Current Inventory</h2>
      <div>
        <table>
          <thead>
            <tr>
              <th>Model</th>
              <th>Installed/Original OS</th>
              <th>Last Supported OS</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Manually adding the table data as per the request
            $inventory_os_data = [
              ["MacBook (Retina, 12-inch, Early 2015)", "El Capitán", "Big Sur"],
              ["MacBook Pro (15-inch, 2.53GHz, Mid 2009)", "Leopard", "El Capitán"],
              ["MacBook Pro (15-inch, 2016)", "High Sierra", "Monterey"],
              ["iMac (Retina 5K, 27-inch, Late 2014)", "Yosemite", "Big Sur"],
              ["Mac Pro (Late 2013)", "Mojave", "Monterey"],
              ["MacBook Pro (15-inch, 2.4GHz, Mid 2010)", "Snow Leopard", "High Sierra"],
              ["Mac Pro (Mid 2010)", "Snow Leopard", "Mojave"]
            ];
            foreach ($inventory_os_data as $row): ?>
              <tr>
                <td><?php echo htmlspecialchars($row[0]); ?></td>
                <td><?php echo htmlspecialchars($row[1]); ?></td>
                <td><?php echo htmlspecialchars($row[2]); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </body>
</html>
