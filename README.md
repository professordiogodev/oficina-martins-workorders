# Oficina Martins & Filhos — Work Orders (2003)

Small web app used since 2003 by **Oficina Martins & Filhos**, a family-owned car repair shop, to register
cars coming in for repair, close jobs with the final price, and export everything to CSV for the accountant.

It was written by a freelancer in **PHP 3** and has been running ever since on a single beige PC
under the counter (Debian 3.0 "woody", Apache 1.3). That PC is now dying, and the code + data
in this repository are a copy taken from its disk.

```
workorders/          the application (copy this to /var/www/workorders/)
  index.php3         list of work orders (filter by OPEN / DONE)
  new_order.php3     register a car that came in
  close_order.php3   close a job with the final price
  export.php3        download all orders as CSV
  lib.inc.php3       flat-file "database" functions
  config.inc.php3    shop name, data file path
  data/orders.dat    ALL the shop's data (pipe-separated text file)
docs/
  SERVER_NOTES.txt   how the original server was set up (by the original developer)
```

## Requirements (original, 2003)

| Component  | Version                        |
|------------|--------------------------------|
| OS         | Debian GNU/Linux 3.0 "woody"   |
| Web server | Apache 1.3.26                  |
| PHP        | 3.0.18 (Apache module, `.php3`)|
| Database   | none — flat file `data/orders.dat` |

## Can I run it on my machine?

**No — not directly.** This code depends on a runtime that no modern OS ships anymore:

- PHP 3 is not packaged by any current Linux distribution (or Homebrew, or anything else).
- The code relies on `register_globals` (form fields become variables), removed in PHP 5.4.
- It uses `each()` and `ereg_replace()`, removed in PHP 7/8 → `Fatal error: Call to undefined function each()`.
- It uses short `<?` tags, disabled by default today → PHP prints the source code instead of running it.

The only practical way to run it today is to **recreate the 2003 environment inside a Docker container**
using the `debian/eol:woody` image (an archived Debian 3.0 that still installs PHP 3 from `archive.debian.org`),
following the original instructions in [`docs/SERVER_NOTES.txt`](docs/SERVER_NOTES.txt).

Quick version:

```bash
git clone https://github.com/professordiogodev/oficina-martins-workorders.git
cd oficina-martins-workorders
docker run -it --name martins -p 8080:80 debian/eol:woody bash
# ...inside the container, follow docs/SERVER_NOTES.txt
# ...in another terminal on your machine:
docker cp workorders martins:/var/www/
```

Then open <http://localhost:8080/workorders/>.

---
*"Best viewed with Internet Explorer 6 at 800x600."*
