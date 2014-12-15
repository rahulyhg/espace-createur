<div class='calendar'>
		<?php
			echo "<span style='display: none' class='num'>$num</span>";
			for ($month = (date('m') - 5); $month <= date("m"); $month++) {
				echo "<div class='month month_$month ";
				if ($month != date("m"))
					echo "ninja";
				echo "'>";
					$timestamp = mktime(0, 0, 0, $month);
					if ($month != (date('m') - 5))
						echo "<span class='left chevron'><i class='fa fa-chevron-left'></i></span>";
					if ($month != date("m"))
						echo "<span class='right chevron'><i class='fa fa-chevron-right'></i></span>";
					echo "<h3>".date("F", $timestamp)."</h3>";
					echo "<span class='num' style='display: none'>$month</span>";
					echo "<table>";
					echo "<tr>";
					for ($i = 1; $i <= 7; $i++) {
						echo "<th>".date("D", mktime(0, 0, 0, $month, $i))."</th>";
					}
					echo "</tr>";
					for ($i = 1, $j = 0; $i <= date("t", $timestamp); $i++, $j++) {
						if ($j == 0)
							echo "<tr>";
						else if ($j == 7) {
							$j = 0;
							echo "</tr><tr>";
						}
						echo "<td><span class='";
						if ($i < 10)
							echo "single ";
						if ($i == date("d") && $month == date("m"))
							echo "today";
						echo "'>$i</span></td>";
					}
					echo "</table>";
				echo "</div>";
			}
		?>
</div>
