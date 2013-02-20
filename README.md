magento-remotejs
================

Adding support for remote JS and CSS in Magento layout files.

How to use
----------

To add an external javascript write:
```xml
<action method="addJs"><script>//cdn.google.com/library.js</script></action>
```

For CSS:
```xml
<action method="addCss"><href>//cdn.yourdomain.com/style.css</href></action>
```

The key is using either // or http:// and it'll automatically understand that it should not prepend the site url.

License
-------

> This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

> This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

> You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
