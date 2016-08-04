#!/bin/bash

# Run phing with the right paths from any location
BASEDIR=$(dirname $0)
${BASEDIR}/bin/phing -f ${BASEDIR}/build.xml $1
